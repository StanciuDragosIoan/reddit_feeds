const Renderer = {
  renderFeeds: (res, data) => {
    const feeds = Object.entries(JSON.parse(data).data.children);

    res.write(`
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        <style>
            .card{
                display:block;
                margin:auto;
                width:60vw;
                border:2px solid #ccc;
                padding:1rem;
                text-align:center; 
            }

            .text {
                font-size:2rem;
                text-align:center;
            }

            .title {
                text-align:center;
                font-size:2.5rem;
            }

            .filter {
                display:block;
                margin:auto;
                width:30rem;
                height:3rem;
                font-size:2rem;'
                text-align:center;
                margin-bottom:1rem;
            }

            ::-webkit-input-placeholder {
              text-align: center;
          }
        </style>
        <title>Document</title>
    </head>
    <body>
        <h1 class='title'>Welcome to the Reddits Feed</h1>
        <p class='text'>Please use the input field below to filter reddits by author, title, subreddit: </p>
        <input  oninput='filter()' type='text' class='filter' placeholder='search for stuff'>
        ${feeds.map((f) => {
          let timestamp = f[1].data.created;
          let date = new Date(timestamp * 1000);

          return `<div class='card subreddit'>
                        <h3 class='title'>${f[1].data.title}</h3>
                        <p class='text'>subreddit: ${f[1].data.subreddit}</p>
                        <p class='text'>author: ${f[1].data.author_fullname}</p>
                        <p class='text'><a href=${f[1].data.url} target='_blank'>Link</a>: </p>
                        <p class='text'>Created at: ${date}</p>
                  </div>`;
        })}
    `);

    Renderer.renderClientScript(res);

    res.end();
  },

  renderClientScript: (res) => {
    res.write(`  
    <script>
   
    const filter = () => {
      
      //filter by title, subreddit, author
       document.querySelectorAll('.card.subreddit').forEach((item) => {
         let value = document.querySelector('.filter').value.toLowerCase();
           
         const title = item.children[0].innerText;
         
         const subreddit = item.children[1].innerText.split(' ')[1];
         
         const author = item.children[2].innerText.split(' ')[1];
         
        if (
          author.toLowerCase().indexOf(value) != -1 ||
          subreddit.toLowerCase().indexOf(value) != -1 ||
          title.toLowerCase().indexOf(value) != -1
        ) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
       });
    };
      
</script>
    </body>
    </html>`);
  },
};

module.exports = Renderer;
