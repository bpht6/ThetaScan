# ThetaScan.io

A PHP block explorer for the Theta Blockchain.

**Version 1.00.00**:

* Records all coinbase transactions (type 0).
* Records all staking and unstaking transactions (type 9 and 10).
* Records all send transactions (type 2).
* Calculates all the wallet address being paid out from staking roughly every 10 minutes. Then determines if they are active, inactive or in withdraw.
* Added JSON export of transaction.
* Added CSV export of all coinbase transaction by year.
* Added CSV export of all address transaction (limited to 50,000).
* Added separation to all Type 2 transaction based on output address. (each output is stored as a separate transaction in the database for quick searches.)
* Added JSON printout for any un-mapped transaction.
* Added loading screens while it looks up the transaction information for slower web servers.
* Integrated CMC prices into the website prices update ever 10 minutes.
