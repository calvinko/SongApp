#! /usr/bin/python

def countNumeric(line):
    i = 0
    for c in line:
        if c.isdigit():
            i = i + 1
    return i


fp = open("song1.txt", "r")
lines = fp.readlines()
for line in lines:
    if len(line) > 1 and countNumeric(line) < 4:
        print line.strip()


