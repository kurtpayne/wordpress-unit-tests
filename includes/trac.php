<?php

class TracTickets {
	/**
	 * When open tickets for a Trac install is requested, the results are stored here.
	 *
	 * @var array
	 */
	protected static $trac_ticket_cache = array();

	/**
	 * Checks if track ticket #$ticket_id is resolved
	 *
	 * @return bool|null true if the ticket is resolved, false if not resolved, null on error
	 */
	public static function isTracTicketClosed( $trac_url, $ticket_id ) {
		if ( ! isset( self::$trac_ticket_cache[ $trac_url ] ) ) {
			$tickets = file_get_contents( $trac_url . '/query?status=%21closed&format=csv&col=id' );
			$tickets = substr( $tickets, 2 ); // remove 'id'
			$tickets = trim( $tickets );
			$tickets = explode( "\r\n", $tickets );
			self::$trac_ticket_cache[ $trac_url ] = $tickets;
		}

		return ! in_array( $ticket_id, self::$trac_ticket_cache[ $trac_url ] );
	}
}