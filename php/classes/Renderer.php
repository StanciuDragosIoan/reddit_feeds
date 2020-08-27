<?php

class Renderer
{

  public function renderHead(
    $title = "Reddit Feed",
    $desc = "Reddit Feed App",
    $img = "/images/sample.jpg"
  ) {
    $html = <<<"EOT"
          <!DOCTYPE html>
          <html lang="en">
            <head>
              <meta charset="UTF-8" />
              <meta name="viewport" content="width=device-width, initial-scale=1.0" />
              <style>
                  body {
                    font-size:2rem;
                  }
                  .card {
                    display:block;
                    margin:auto;
                    width:60vw;
                    margin-bottom:5rem;
                    border:2px solid #ccc;
                    padding:1rem;
                    text-align:center;
                  }

                  .filter {
                      display:block;
                      margin:auto;
                      width:30rem;
                      height:3rem;
                      font-size:2rem;'
                      text-align:center;
                  }

                  ::-webkit-input-placeholder {
                    text-align: center;
                }
              </style>
              <title>$title</title>
            </head>
            <body>
              <div class="card">
              <h1>Welcome to the $title</h1>
              <p>Please see below the latest reddit feeds from the latest 24 hours</p>
              <p>Our feeds are update once every hour</p>
              
              <p>Please feel free to filter through them to find something fun</p>
              </div>
        
          
      EOT;

    echo $html;
  }


  /*
     *  Takes feeds array and outputs list of cards
     */
  public function renderFeeds($array)
  {


    foreach ($array as $i) {
      $timestamp = $i['data']['created'];
      $datetimeFormat = 'Y-m-d H:i:s';
      $date = new \DateTime();
      $date->setTimestamp($timestamp);

      echo "
      <div class='card subreddit'>
        <h3>{$i['data']['title']}</h3>
        <p>Subreddit: {$i['data']['subreddit']}</p>
        <p class='author'>Author: {$i['data']['author']}</p>
        <p>Link: <a href={$i['data']['url']} target='_blank'> LINK </a></p>
        <p>Created at: {$date->format($datetimeFormat)} </p>
      </div>
     ";
    }
  }

  public function renderFooter()
  {
    $html = <<<"EOT"
      </body>
      </html>
        
     EOT;

    echo $html;
  }


  /*
     * Renders the filter
     */
  public function renderFilter()
  {
    echo "
    <p class='card'>Please filter by title, author, subreddit by searching in the field below:</p>
     <input type='text' oninput='filter()' class='filter' placeholder='search for stuff'>
    ";
  }

  /*
   * Renders client script + filter mechanism
   */
  public function renderClientScript($data)
  {
    $jsData = json_encode($data);
    // $jsData = json_encode($data);
    echo "
      <script>
          const clientData = {$jsData};
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
    ";
  }
}
