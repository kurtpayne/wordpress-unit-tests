import unicodedata, codecs

# Generates testdata for the WordPress `remove_accents` function.
#
# Unicode defines character decompositions: e.g., an
# e with an umlaut (LATIN SMALL LETTER E WITH DIAERESIS) decomposes
# to 0x0065 (LATIN SMALL LETTER E) and 0x0308 (COMBINING DIAERESIS).
#    
# Some characters aren't decomposable, but still have ASCII
# representations, e.g. the "ae" ligature should be written as "ae".
#
#
# This code derives from the work of Fredrik Lundh / effbot
# <http://effbot.org/zone/unicode-convert.htm>
#
# He uses different replacements ("d" for eth, "oe" for o-with-stroke, etc.)
# but the below follows Wordpress's behaviour.
#

CHAR_REPLACEMENT = {
    # latin-1 characters that don't have a unicode decomposition
    0xc6: u"AE", # LATIN CAPITAL LETTER AE
    0xd0: u"DH",  # LATIN CAPITAL LETTER ETH
    0xd8: u"O", # LATIN CAPITAL LETTER O WITH STROKE
    0xde: u"TH", # LATIN CAPITAL LETTER THORN
    0xdf: u"ss", # LATIN SMALL LETTER SHARP S
    0xe6: u"ae", # LATIN SMALL LETTER AE
    0xf0: u"dh",  # LATIN SMALL LETTER ETH
    0xf8: u"o", # LATIN SMALL LETTER O WITH STROKE
    0xfe: u"th", # LATIN SMALL LETTER THORN
    0x13f: u"L", # LATIN CAPITAL LETTER L WITH MIDDLE DOT
    0x140: u"l", # LATIN SMALL LETTER L WITH MIDDLE DOT
    0x149: u"N" # LATIN SMALL LETTER N PRECEDED BY APOSTROPHE
    }

# Latin-1 Supplement (0080-00FF): identical to ISO-8859-1.
# 0080009F are control characters, 00A000BF are currency symbols, 
# punctuation and numerals.
latin1_supplement = map(unichr, range(0x00C0, 0x0100))

# Latin Extended-A 0100017F
latin_extended_a = map(unichr, range(0x0100, 0x0180))


def remove_accents(chars):
    """Divides a given string into decomposable and undecomposable characters."""
    decomposable = []
    undecomposable = []
    for c in chars:
        de = unicodedata.decomposition(c)
        if de:
            dechars = de.split(None)
            try:
                # Only keep characters with a decimal value < 300
                dechars = map(lambda i: int(i, 16), dechars)
                dechars = filter(lambda i: i < 300, dechars)                
                dechars = map(unichr, dechars)
                de = "".join(dechars)
            except (IndexError, ValueError):
                if ord(c) in CHAR_REPLACEMENT:
                    de = CHAR_REPLACEMENT[ord(c)]
                else:
                    dechars = filter(lambda s: s[0] != "<", dechars)
                    dechars = map(lambda i: int(i, 16), dechars)
                    dechars = map(unichr, dechars)
                    de = "".join(dechars)
                undecomposable.append((c, de))
            else:
                decomposable.append((c, de))
        else:
            if ord(c) in CHAR_REPLACEMENT:
                de = CHAR_REPLACEMENT[ord(c)]
                undecomposable.append((c, de))
    return decomposable, undecomposable

def write_cases(case, data, in_encoding="utf-8", out_encoding="utf-8"):
    if not isinstance(data[0], list):
        data = [data]

    print "generating %s data" % case
    infile = codecs.open(case + ".input.txt", "w", in_encoding)
    outfile = codecs.open(case + ".output.txt", "w", out_encoding)
    
    for data_ in data:
        inline, outline = zip(*data_)
        infile.write("".join(inline) + "\n")
        outfile.write("".join(outline) + "\n")
    infile.close()
    outfile.close()


if __name__ == "__main__":
    l1s_decomposable, l1s_undecomposable = remove_accents(latin1_supplement)
    l1s_both = l1s_decomposable + l1s_undecomposable
    
    lea_decomposable, lea_undecomposable = remove_accents(latin_extended_a)
    lea_both = lea_decomposable + lea_undecomposable
    
    
    write_cases("removes_accents_from_decomposable_latin1_supplement", 
        l1s_decomposable, in_encoding="iso-8859-1", out_encoding="ascii")
    
    write_cases("removes_accents_from_undecomposable_latin1_supplement", 
        l1s_undecomposable, in_encoding="iso-8859-1", out_encoding="ascii")
    
    write_cases("removes_accents_from_latin1_supplement", 
        l1s_both, in_encoding="iso-8859-1", out_encoding="ascii")
    
    write_cases("removes_accents_from_decomposable_latin_extended_a", 
        lea_decomposable, in_encoding="utf-8", out_encoding="ascii")
    
    write_cases("removes_accents_from_undecomposable_latin_extended_a", 
        lea_undecomposable, in_encoding="utf-8", out_encoding="ascii")
    
    write_cases("removes_accents_from_latin_extended_a", 
        lea_both, in_encoding="utf-8", out_encoding="ascii")
    
    write_cases("removes_accents_from_latin1_supplement_and_latin_extended_a",
        l1s_both + lea_both, in_encoding="utf-8", out_encoding="ascii")

