<?php

class TracTickets {
	/**
	 * Whenever a track ticket is checked to see if it's closed or not
	 * the results are stored here
	 * @var array
	 */
	protected static $trac_ticket_cache = array();

	/**
	 * Checks if track ticket #$ticket_id is resolved
	 *
	 * @return bool|null true if the ticket is resolved, false if not resolved, null on error
	 */
	static function isTracTicketClosed($trac_url, $ticket_id) {
		$trac_url = rtrim($trac_url, '/');
		$url = "$trac_url/ticket/$ticket_id?format=tab";
		if ( array_key_exists( $url, self::$trac_ticket_cache ) ) {
			return self::$trac_ticket_cache[$url];
		}
		$ticket_tsv = file_get_contents($url);
		if (false === $ticket_tsv) {
			self::$trac_ticket_cache[$url] = null;
			return self::$trac_ticket_cache[$url];
		}
		$lines = explode("\n", $ticket_tsv, 2);
		if (!is_array($lines) || count($lines) < 2) {
			self::$trac_ticket_cache[$url] = null;
			return self::$trac_ticket_cache[$url];
		}
		$titles = str_getcsv( $lines[0], "\t" );
		$status_idx = array_search('status', $titles);
		if (false === $status_idx) {
			self::$trac_ticket_cache[$url] = null;
			return self::$trac_ticket_cache[$url];
		}
		$tabs = str_getcsv( $lines[1], "\t" );
		self::$trac_ticket_cache[$url] = ( 'closed' === $tabs[$status_idx] );
		return self::$trac_ticket_cache[$url];
	}
}