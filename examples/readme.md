# ThetaScan.io

A PHP block explorer for the Theta Blockchain.  

To run these examples you must have a Linux Server running a Theta Node on port 16888.  If it is running on a different port you will need to edit the example file to the correct port number.

**Example 1**: 

Using a post or get you can retreive a balance from a node using an external application.

Swift 5 Example:
```
let url = URL(string: "https://example.com")!
var components = URLComponents(url: url, resolvingAgainstBaseURL: false)!

components.queryItems = [
    URLQueryItem(name: "address", value: "0xc15149236229bd13f0aec783a9cc8e8059fb28da"),
]

let query = components.url!.query
```

**Example 2**: 



**Example 3**: 



