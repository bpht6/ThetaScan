# ThetaScan.io

A PHP block explorer for the Theta Blockchain.

**MySQL**: 

During coding version 0.33.01 posted to the database from block 0 and double posted all the transactions.  Safe guards where added to prevent this in all future versions.  If for some reason blocks need to be reprocessed to be added to the database or corrected this will allow you to delete and reprocess the required blocks.

**Setup**

You will need to include a password in you config.ini file
