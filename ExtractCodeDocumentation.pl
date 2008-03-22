#!/usr/bin/perl -w

# *************************************************************************
# * ExtractCodeDocumentation: Simple script to extract 'non-standard' XML *
# * documentation from a source code file.                                *
# * Version 1.0.0 (08 September 2006)                                     *
# * Copyright (C) 2006 Trevor Barnett                                     *
# *                                                                       *
# * This program is free software; you can redistribute it and/or modify  *
# * it under the terms of the GNU General Public License as published by  *
# * the Free Software Foundation; either version 2 of the License, or     *
# * (at your option) any later version.                                   *
# *                                                                       *
# * This program is distributed in the hope that it will be useful,       *
# * but WITHOUT ANY WARRANTY; without even the implied warranty of        *
# * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         *
# * GNU General Public License for more details.                          *
# *                                                                       *
# * You should have received a copy of the GNU General Public License     *
# * along with this program; if not, write to the Free Software           *
# * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  *
# * USA                                                                   *
# *************************************************************************

use strict;

my $sourceCodeFile = $ARGV[0];

if (!defined $sourceCodeFile)
{
    print "Please give path of source code file.\n";
    exit;
}

if (!open FILE, "<$sourceCodeFile")
{
    print "Unable to read file: $sourceCodeFile\n";
    exit;
}

my @lines = <FILE>;
close FILE;

print "<document>\n";
my $startClass = 0;
foreach my $line (@lines)
{
    chomp $line;
    if ($line =~ /^\s*\/\/\*\s*(<class.*)$/)
    {
        if ($startClass)
        {
            print "</class>\n";
        }
        $startClass = 1;
        print "$1\n";
    }
    elsif ($line =~ /^\s*\/\/\*\s*(<\/class.*)$/)
    {
        # skip it!
    }
    elsif ($line =~ /^\s*\/\/\*\s*(.*)$/)
    {
        print "$1\n";
    }
}
if ($startClass)
{
    print "</class>\n";
}
print "</document>\n";
