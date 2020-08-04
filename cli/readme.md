# ThetaScan.io

Thetascan.io's CLI interface which is a client side JavaScript coding that interacts directly with Theta Explorer API and does not use a local node. It can be ran directly from your desktop.

This CLI is using https://explorer.thetatoken.org:9000/api/ to return the information.  It could be edited to return from a local host or another api with external access enabled.

**Commands**: 

* address [address] - Returns the balance of an address.
* backgroundcolor [name] - Changes the background color of the window.
* block [number] - Returns details from a block number.
* color [name] - Changes the text color of the window.
* exit - Closes the CLI interface.
* hash [transaction hash] - Return a type 2 transaction hash details.
* help - The menu you are reading right now.
* lastblock - Returns the last 6 blocks that are finalized on the Theta Network.
* lasttransaction - Returns the last 10 transactions that are finalized.
* thetastaked - Returns the total amount of theta staked.
* thetasupply - Returns the total supply of theta.
* thetatodamoon - Displays a rocket ship names theta going to da moon.
* tfuelsupply - Returns the total supply of TFuel.
* topaddress - Returns the top 6 Theta wallet address and their balances.
* staked [address] - Returns the total amount of Theta staked and the Node Address.
