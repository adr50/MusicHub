#!/bin/bash
#To run this script: chmod +x scp_migrate
#Should have 2 scp files: to transfer files from Dev to Q/A and to transfer files from Q/A to Production.
#Replace hostname with your machinename and ipaddress with destination machine IP
scp /home/hostname/MusicHub ipaddress:/home/hostname/MusicHub
