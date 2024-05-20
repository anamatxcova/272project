
//draw stars based on user selection
const allStars = document.querySelectorAll('.star');
let current_star;
allStars.forEach((star, i) => {
    star.onclick = function () {
        current_star = i + 1;
        allStars.forEach((star, j) => {
            if (current_star >= j + 1) {
                star.innerHTML = '&#9733'
            } else {
                star.innerHTML = '&#9734'
            }
        })
    }
})

//show all reviews for the product 
var pstar = document.querySelector('.pstar');
var prating = document.querySelector('.prating');
let product_rate;
let totalRate = 0;
let totalReview = 0;
var output = document.querySelector(".reviews");
output.innerHTML = "Loading...";

let data = new FormData();
//productName and vendorName will be changed later
data.append('productName', 'Peach Oolong Tea');
data.append('vendorName', 'Cup of Ice Tea');

fetch("./api/loadReviews.php", {
    method: "POST",
    body: data,

})
    .then((response) => response.json())
    .then((data_arr) => {
        output.innerHTML = "";
        totalReview = data_arr.length;
        data_arr.forEach((review) => {
            const newDiv = document.createElement("div");
            const rating_text = document.createElement("p");
            const rating_text_cont = document.createTextNode(review.text);
            rating_text.appendChild(rating_text_cont);
            newDiv.appendChild(drawStars(review.rating));
            newDiv.appendChild(rating_text);
            output.appendChild(newDiv);
            const divider = document.createElement("hr");
            output.appendChild(divider);
            totalRate += Number(review.rating);
        })
        //calculate the average rating for the product
        if (totalReview != 0) product_rate = totalRate / totalReview;
        else product_rate = 0;
        pstar.style.setProperty('--rating', product_rate);
        prating.innerHTML = product_rate + "/5";
    });

//send user review to backend
function sendReview() {
    var mes = document.querySelector(".message");
    let reviewText = document.querySelector('.rating_text').value;
    var rateData = new FormData();
    rateData.append('productName', 'Peach Oolong Tea');
    rateData.append('vendorName', 'Cup of Ice Tea');
    rateData.append('rating', current_star);
    rateData.append('text', reviewText);
    fetch("./api/addReviews.php", {
        method: "POST",
        body: rateData,

    })
        .then((response) => response.text())
        .then((json) => mes.innerHTML = json);
}

//helper function to draw star rating for each review
function drawStars(score) {
    const starSys = document.createElement("div");
    starSys.className = "rstar_system";
    for (let i = 0; i <= 4; i++) {
        const star = document.createElement('button');
        star.innerHTML = "&#9733;"
        if (i <= score - 1)
            star.style.color = '#ff9880';
        else
            star.style.color = '#adaca8';
        star.className = "rstar";
        starSys.appendChild(star);
    }
    return starSys;
}