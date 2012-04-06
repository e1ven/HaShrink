#!/usr/bin/env python
#
# Copyright 2011 CPD
    

import hashlib,os
from BitVector import BitVector
import itertools
import idmp3

def hashfile(path):
	SHA512 = hashlib.sha512()
	File = open(path,'rb')
	while True:
		buf = File.read(0x100000)
		if not buf:
			break
		SHA512.update(buf)
	File.close()
	return SHA512.hexdigest()

path = '/Volumes/ramdisk/'
filename = 'sinewave.mp3'

originalhash = hashfile(path + filename)
originalbytesize = os.path.getsize(path + filename)
originalbitsize = originalbytesize * 8

print("Looking for files of size: " + str(originalbitsize))


#iterate through each combination

validhash = 0
validmp3 = 0

for bitlist in itertools.product([0,1],repeat=originalbitsize):
	bv = BitVector(bitlist=bitlist)
	newpath = path + 'testfile.mp3'
	testfile = open(newpath,'wb')
	bv.write_to_file(testfile)
	testfile.close()
	newhash = hashfile(newpath)
	if newhash == originalhash:
		goodpath = path + 'candidate' + str(validhash) +  '.mp3'
		print("Possible Candidate at " + goodpath)
		os.rename(newpath,goodpath)
                if idmp3.isMp3Valid(goodpath):
                    mp3path = path + '-validmp3-' + str(validmp3) +  '.mp3'
                    print("Possible mp3 at " + mp3path)
                    os.rename(goodpath,mp3path)
                    validmp3 += 1
                else:
                    print(" but, alas, no.")
		validhash += 1
	else:
		print(newhash + " does not match " + originalhash + "; deleting " + newpath )
		os.remove(newpath)
