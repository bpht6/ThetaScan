# ThetaScan.io

A PHP block explorer for the Theta Blockchain.  

To run these examples you must have a Linux Server running a Theta Node on port 16888.  If it is running on a different port you will need to edit the example file to the correct port number.

**Example 1**: 

This returns an address balance.
Using a post or get you can retreive a balance from the node using an external application or the web server.

Swift 5 Example:
```
let url = URL(string: "https://yourwebsite.com/example1.php")!
var components = URLComponents(url: url, resolvingAgainstBaseURL: false)!

components.queryItems = [
    URLQueryItem(name: "address", value: "0xc15149236229bd13f0aec783a9cc8e8059fb28da"),
]

let query = components.url!.query
```

**Example 2**: 

This returns a hash's details.
Using a post or get you can retreive a hash's details from the node using an external application or the web server.

Swift 5 Example:
```
let url = URL(string: "https://yourwebsite.com/example2.php")!
var components = URLComponents(url: url, resolvingAgainstBaseURL: false)!

components.queryItems = [
    URLQueryItem(name: "hash", value: "0xd25c5d038c5b6fa62ab2d208c6da25765ba84ab292756cb1f283445476bc49f4"),
]

let query = components.url!.query
```

**Example 3**: 

This sends a signed transaction accross the blockchain.
Using a post or get you can send a transaction from the node using an external application or the web server.

Swift 5 Example:
```
let url = URL(string: "https://yourwebsite.com/example3.php")!
var components = URLComponents(url: url, resolvingAgainstBaseURL: false)!

components.queryItems = [
    URLQueryItem(name: "tx_bytes", value: "02f8a4c78085e8d4a51000f86ff86d942e833968e5bb786ae419c4d13189fb081cc43babd3888ac7230489e800008901158e46f1e875100015b841c2daae6cab92e37308763664fcbe93d90219df5a3520853a9713e70e734b11f27a43db6b77da4f885213b45a294c2b4c74dc9a018d35ba93e5b9297876a293c700eae9949f1233798e905e173560071255140b4a8abd3ec6d3888ac7230489e800008901158e460913d00000"),
]

let query = components.url!.query
```

