<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <style>
        .product_page{
            width: 80vw;
            height:auto;
            margin: 0 auto;
        }
        .rating_system{
            display:flex;
            flex-direction:column;
            align-items: center;
        }
        .product_rate{
            display:flex;
            flex-direction:row;
            justify-content:center;
        }
        .star_system,.pstar_system{
            user-select:none;
            text-align:center;
        }
        .rstar_system{
            user-select:none;
        }
        .star,.rstar{
            font-size: 30px;
            color: #ff9880;
            background-color: unset;
            border:none;
            padding:3px;
        }
        .pstar{
            font-size: 30px;
            color: #ff9880;
            --percent: calc(var(--rating) /5 *100%);
            
            &::before {
            content: '★★★★★';
            letter-spacing: 3px;
            background: linear-gradient(90deg, #ff9880 var(--percent), #adaca8 var(--percent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
  }
        }
        .star:hover{
            cursor: pointer;
            background-color:unset;
            color: unset;
            color: #ff9880;
        }
        .pstar:hover,.rstar:hover{
            cursor:default;
            background-color:unset;
            color: #ff9880;
        }
        .rating_text{
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class = "product_page">
        <!--URL should be retrieved from cookies-->
        <?php
            $url_name = "https://cupoficetea.com/items/item1.html";
            $ch_session = curl_init();
            curl_setopt($ch_session, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch_session, CURLOPT_URL, $url_name);
            $result_url = curl_exec($ch_session);
            echo $result_url;
        ?>
    </div>
    <div class = "product_rate">
        <h1>Rating Score:</h1>
        <div class ="pstar_system">
            <div class = "pstar"></div>
            <p class = prating></p>
        </div>
    </div>
    <div class = "rating_system">
        <h3>Submit a Review</h3>
      
        <div>Review Stars</div>
        <div class ="star_system">
            <button class ="star">&#9734;</button>
            <button class ="star">&#9734;</button>
            <button class ="star">&#9734;</button>
            <button class ="star">&#9734;</button>
            <button class ="star">&#9734;</button>
        </div>
        <div>Review Text</div>
        <input type = 'text' class = "rating_text">
        <button onclick ="sendReview()">Submit</button>
        <p class = "message"></p>
    </div>
    <div class = "rating_list">
        <h3>Reviews</h3>
        <div type="text/javascript" class ="reviews"></div>
    </div>
    <script type="text/javascript" src= "js/review.js"></script>

</body>
</html>