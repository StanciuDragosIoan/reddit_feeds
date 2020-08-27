const http = require("http");
const PORT = process.env.port || 5555;
const apiCaller = require("./modules/ApiCall");
const renderer = require("./modules/Renderer");
const fs = require("fs");

const server = http.createServer((req, res) => {
  res.setHeader("Content-Type", "text/html");

  let url = req.url;
  if (url === "/") {
    const apiUrl = "https://www.reddit.com/.json?limit=99999";
    //call api once to make sure we have at least some data
    apiCaller.call(apiUrl);
    let data = fs.readFile("./data/apiResponse.json", "utf8", (err, data) => {
      if (err) {
        throw err;
      }

      renderer.renderFeeds(res, data);
    });
    //call api every 10 min
    setTimeout(() => {
      apiCaller.call(apiUrl);
    }, 3600000);
  }
});

console.log(`Server is running on port: ${PORT} so our API is alive =)`);
server.listen(PORT);
