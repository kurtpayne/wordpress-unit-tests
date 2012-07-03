# Generates test data for the utf8_uri_encode function in formatting.php
# Pipe UTF-8 data to stdin and accept it from stdout

import urllib, codecs, re
import sys

# uncapitalize pct-encoded values, leave the rest alone
capfix = re.compile("%([0-9A-Z]{2})");
def fix(match):
    octet = match.group(1)
    intval = int(octet, 16)
    if intval < 128:
        return chr(intval).lower()
    return '%' + octet.lower()

def urlencode(line):
    """Percent-encode each byte of non-ASCII unicode characters."""
    line = urllib.quote(line.strip().encode("utf-8"))
    line = capfix.sub(fix, line)
    return line

if __name__ == "__main__":
    args = sys.argv[1:]
    if args and args[0] in ("-h", "--help"):
        print "Usage: python urlencode.py < utf8-lines.txt > utf8-urlencoded-lines.txt"
        sys.exit(2)

    sys.stdin = codecs.getreader("utf-8")(sys.stdin)
    sys.stdout = codecs.getwriter("ascii")(sys.stdout)    
    
    lines = sys.stdin.readlines()
    sys.stdout.write( "\n".join(map(urlencode, lines)) )
