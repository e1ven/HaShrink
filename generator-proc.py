#!/usr/bin/env python
#
# Copyright 2011 CPD
    

import hashlib,os,time
import multiprocessing
from multiprocessing.managers import BaseManager
from BitVector import BitVector
import itertools
import idmp3

class hashly(object):

    def hashfile(self,path):
        SHA512 = hashlib.sha512()
        File = open(path,'rb')
        while True:
            buf = File.read(0x100000)
            if not buf:
                break
            SHA512.update(buf)
        File.close()
        return SHA512.hexdigest()

    def __init__(self):
        self.path = '/mnt/ram/'
        self.filename = 'sinewave.mp3'

        self.originalhash = self.hashfile(self.path + self.filename)
        self.originalbytesize = os.path.getsize(self.path + self.filename)
        self.originalbitsize = self.originalbytesize * 8
        self.definedworkers = 2
        self.procs = []
        self.queue = multiprocessing.Queue()

    def iterator(self,max=None):
        if max == None:
            max = self.definedworkers * 10
        for bitlist in itertools.product([0,1],repeat=self.originalbitsize):
            #Never get too big. You'll overload memory with every possible combo.
            while self.queue.qsize() >= max:
                time.sleep(5)
            if self.queue.qsize() < max:
                self.queue.put(bitlist)
                print("Refilling the hopper")


    def calculate(self):
        #iterate through each combination
        goodcount = 0

        counting = multiprocessing.Process(target=self.iterator, args=[])
        self.procs.append(counting)

        for th in range(0,self.definedworkers):
            newproc = multiprocessing.Process(target=self.generate, args=(th,))
            self.procs.append(newproc)
            print(" Created Process - " + str(th))

        print("Starting Processes::")
        count = 0
        for th in self.procs:
             th.start()
             print(" Started " + str(count))
             time.sleep(1)
             count += 1

    def printstatus(self):
        print("self.originalhash " + str(self.originalhash))
        print("self.originalbytesize " + str(self.originalbytesize))
        print("self.originalbitsize " + str(self.originalbitsize))
        print("self.definedworkers" + str(self.definedworkers))
        print("Current Process count: " + str(len(self.procs)))

    def generate(self,id):
        validhash = 0
        validmp3 = 0
        while self.queue.qsize() > 0:
            bitlist = self.queue.get()
            bv = BitVector(bitlist=bitlist)
            newpath = self.path + 'testfile.mp3'
            testfile = open(newpath,'wb')
            bv.write_to_file(testfile)
            testfile.close()
            newhash = self.hashfile(newpath)
            if newhash == self.originalhash:
                goodpath = self.path + 'candidate' + str(validhash) +  '.mp3'
                print("Possible Candidate at " + goodpath)
                os.rename(newpath,goodpath)
                if idmp3.isMp3Valid(goodpath):
                    mp3path = self.path + '-validmp3-' + str(validmp3) +  '.mp3'
                    print("Possible mp3 at " + mp3path)
                    os.rename(goodpath,mp3path)
                    validmp3 += 1
                else:
                    print(" but, alas, no.")
                validhash += 1
            else:
                print(newhash + " does not match " + originalhash + "; deleting " + newpath )
                os.remove(newpath)

if __name__ == '__main__':
    a = hashly()
    a.printstatus()
    a.calculate()

