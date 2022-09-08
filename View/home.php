<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="home.css">
    <title>Document</title>
</head>

<body>
    <div class="head-1">
        <div class="row d-flex align-items-center">
            <div class="col-6">
                <h6 class="text-center head_1_title">Welcome User</h6>

            </div>
            <div class="col-6">
                <ul class="d-flex justify-content-center align-items-center  top-header">
                    <li><i class="fa-brands fa-square-facebook"></i></li>
                    <li><i class="fa-brands fa-linkedin"></i></li>
                    <li><i class="fa-solid fa-envelope"></i></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- head-2 started -->
    <div class="head-2">
        <div class="row">
            <div class="col-md-4">
                <h4 class="head_2_title text-center text-success">
                    Bengal
                </h4>
            </div>
            <div class="col-md-6 col-sm-12 ">
                <ul class="d-flex top-nav">
                    <li>Home</li>
                    <li>Service</li>
                    <li>About</li>
                    <li><a href="./rent_car.html">Our Cars</a></li>
                    <li>Signin</li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-12 d-flex justify-content-center">
                <button class="btn rent-car">Rent a Car</button>
            </div>
        </div>
    </div>
    <!-- head-2 ended -->
    <img class="img-fluid cover-image" src="./Image/from-1euro-day_background.jpg" alt="">
    <!-- car rent started -->
    <div class="car-rent">
        <div class="row d-flex justify-content-end">
            <div class="col-md-12">
                <h1 class="text-center text-success rent-car-title">RENT A CAR</h1>
            </div>
            <div class="col-md-2 col-sm-12 rent-item">
                <select class="bg-success" name="car-category" id="car_category">
                    <option value="none">Car Category</option>
                    <option value="Premium">Premium</option>
                    <option value="Luxury">Luxury</option>
                </select>
            </div>
            <div class="col-md-2 col-sm-12 rent-item">
                <select class="bg-success" name="pickup-location" id="pickup-location">
                    <option value="none">Pickup Location</option>
                    <option value="dhaka">Dhaka</option>
                    <option value="sylhet">Sylhet</option>
                    <option value="rajsahi">Rajsahi</option>
                    <option value="khulna">Khulna</option>
                    <option value="chittagong">Chittagong</option>
                    <option value="barisa">Barisal</option>
                </select>
            </div>
            <div class="col-md-2 col-sm-12 rent-item">
                <input class="date-picker" placeholder="Pick up Date" type="date">
            </div>

            <div class="col-md-4 col-sm-12 ">
                <button class="btn btn-primary rent-serach">Search</button>
            </div>

        </div>
    </div>

    <div class="footer">
        <div class="row">
            <div class="col-md-3">
               <div class="bengal">
                <h5>Bengal</h5>
                <p>A car rental company that offers
                    cars all over the country.
                    Book your car today to enjoy a first class riding experience.</p>
               </div>
            </div>
            <div class="col-md-3">
                <div class="quick_links">
                    <h5>Quick Links</h5>
                <span>About</span><br>
                <span>Offers & Discounts</span><br>
                <span>Get Cuppon</span><br>
                <span>Contact Us</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="new_products">
                    <h5>New Products</h5>
                <span>Women Cloth</span><br>
                <span>Fahion Accessories</span><br>
                <span>Man Acceessories</span><br>
                <span>Rubber Made Toys</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="support">
                    <h5>Support</h5>
                <span>Frequently Asked Questions</span><br>
                <span>Terms and Conditons</span><br>
                <span>Provacy Policy</span><br>
                <span>Report and payment issue</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
        integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK"
        crossorigin="anonymous"></script>

</body>

</html>