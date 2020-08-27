const https = require("https");
const fs = require("fs");

const ApiCall = {
  call: (url) => {
    https
      .get(url, (resp) => {
        let data = "";
        resp.on("data", (chunk) => {
          data += chunk;
        });

        //write response to file
        resp.on("end", () => {
          fs.writeFile("./data/apiResponse.json", data, (err) => {
            if (err) {
              throw err;
            }
          });
          console.log(`data written to file`);
          return data;
        });
      })
      .on("error", (err) => {
        console.log("Error: " + err.message);
      });
  },
};

module.exports = ApiCall;
