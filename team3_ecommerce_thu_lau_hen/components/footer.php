<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar - Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
    .container {
        margin-top: 0px !important;
    }

    .footer-subscribe-wrapper {
        position: relative;
        z-index: 1;
        height: 100%;
        background: radial-gradient(#92c1ff, #a182ff);
    }

    .footer-heading {
        margin-bottom: 25px;
    }

    .footer-heading h3 {
        font-size: 20px;
        color: black;
        font-weight: 600;
        margin: 0 0 0 0;
        position: relative;
        border-bottom: 1px solid #777;
        padding-bottom: 10px;
    }

    .single-footer-widget .footer-social {
        padding-left: 0;
        margin-bottom: 0;
        margin-top: 20px;
    }

    .single-footer-widget .footer-social li {
        display: inline-block;
        margin-right: 10px;
    }

    .single-footer-widget .footer-social li:last-child {
        margin-right: 0;
    }

    .single-footer-widget .footer-social i {
        display: inline-block;
        height: 35px;
        width: 35px;
        line-height: 35px;
        background-color: #ffffff;
        border: 1px solid #ffffff;
        border-radius: 50px;
        color: black;
        -webkit-transition: 0.4s;
        transition: 0.4s;
        text-align: center;
    }

    .single-footer-widget .footer-social i::before {
        font-size: 15px;
    }

    .single-footer-widget .footer-social i:hover {
        background-color: #7b68ee;
        color: #ffffff;
        border: 1px solid #7b68ee;
    }

    .single-footer-widget p {
        font-size: 15px;
        color: black;
        font-weight: 400;
    }

    .single-footer-widget .footer-heading {
        margin-bottom: 25px;
    }

    .single-footer-widget .footer-heading h3 {
        font-size: 20px;
        color: black;
        font-weight: 700;
        margin: 0 0 0 0;
    }

    .single-footer-widget .footer-quick-links {
        padding-left: 0;
        margin-bottom: 0;
    }

    .single-footer-widget .footer-quick-links li {
        list-style-type: none;
        padding-bottom: 10px;
    }

    .single-footer-widget .footer-quick-links li:last-child {
        padding-bottom: 0;
    }

    .single-footer-widget .footer-quick-links li a {
        display: inline-block;
        color: black;
        font-size: 16px;
        font-weight: 400;
        text-decoration: none;
    }

    .single-footer-widget .footer-quick-links li a:hover {
        color: black;
        text-decoration: underline !important;
        -webkit-transition: 0.4s;
        transition: 0.4s;
    }

    .single-footer-widget .footer-info-contact {
        position: relative;
        padding-left: 0px;
        /*HENRY: "old value = 35px"*/
        margin-bottom: 6px;
        /*HENRY: "old value = 16px"*/
    }

    .single-footer-widget .footer-info-contact:last-child {
        margin-bottom: 0;
    }

    .single-footer-widget .footer-info-contact i {
        color: #ffffff;
        position: relative;
        /*HENRY: "old value = absolute"*/
        padding: 2px;
        margin: 0;
        left: 0;
        top: 0px;
    }

    .single-footer-widget .footer-info-contact i::before {
        font-size: 20px;
    }

    .single-footer-widget .footer-info-contact h3 {
        font-size: 16px;
        color: black;
        font-weight: 600;
        margin: 0 0 10px 0;
    }

    .single-footer-widget .footer-info-contact span {
        font-size: 15px;
        color: black;
        font-weight: 400;
    }

    .single-footer-widget .footer-info-contact span a {
        font-size: 15px;
        color: black;
        font-weight: 400;
        -webkit-transition: 0.4s;
        transition: 0.4s;
    }

    .single-footer-widget .footer-info-contact span a:hover {
        color: black;
    }

    .icon {
        width: 25px;
        height: 25px;
    }
    </style>

</head>

<body>
    <!-- FOOTER START -->
    <footer>
        <div class="footer-area ptb-100 pt-4 border-top border-dark">
            <div class="container ">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-5">
                        <div class="single-footer-widget ">
                            <div class="footer-heading ">
                                <h3>About Us</h3>
                            </div>
                            <p>demo</p>
                            <ul class="footer-social ">
                                <li>
                                    <a href="https://www.facebook.com/CodeFactoryVienna/ "> <i
                                            class="fa fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/accounts/login/ "> <i
                                            class="fa fa-instagram "></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/codefactoryvie "> <i class="fa fa-twitter-square "></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.youtube.com/channel/UCJE5xsfz-bLmVb5emobgOkw "> <i
                                            class="fa fa-youtube-play "></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/company/codefactory-vienna "> <i
                                            class="fa fa-linkedin "></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 pb-5 ">
                        <div class="single-footer-widget ">
                            <div class="footer-heading ">
                                <h3>Useful Links</h3>
                            </div>
                            <ul class="footer-quick-links ">
                                <!-- <li><a href="<?= $url ?>rest_api/products_api.php">API Products</a></li> -->
                                <li><a href="rest_api/products_api.php">API Products</a></li>
                                <li><a href="reviews.php">Reviews</a></li>
                                <li><a href="about.php">About</a></li>
                                <li><a href="contactus.php">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-5 ">
                        <div class="single-footer-widget">
                            <div class="footer-heading ">
                                <h3>Contact Info</h3>
                            </div>
                            <table>
                                <tr class="align-top">
                                    <td><i class="fa fa-phone"></i></td>
                                    <td>
                                        <div class="footer-info-contact ps-2">
                                            <!-- <p class="mb-0"><b>Phone:</b>  -->
                                            <span>0660 6673655</span></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="align-top">
                                    <td><i class="fa fa-envelope"></i></td>
                                    <td>
                                        <div class="footer-info-contact ps-2">
                                            <!-- <p class="mb-0"><b>Email:</b>  -->
                                            <span><a class="text-decoration-none"
                                                    href="mailto:office@codefactory.wien ">office@codefactory.wien</a></span>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="align-top">
                                    <td><i class="fa fa-map-marker"></i></td>
                                    <td>
                                        <div class="footer-info-contact ps-2">
                                            <!-- <p class="mb-0"><b>Address:</b> <br> -->
                                            <span>Kettenbrückengasse 23/2/12,<br> 1050 Vienna, <br>Austria</span></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- FOOTER END -->





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>