<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 ERROR</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<style>
.error-wrapper {
    background-color: #292929;
    height: 100%;
    padding-top: 10%
}

.error-wrapper .error-container {
    -webkit-transform: skew(0deg, -10deg);
    -moz-transform: skew(0deg, -10deg);
    -o-transform: skew(0deg, -10deg);
    -ms-transform: skew(0deg, -10deg);
    transform: skew(0deg, -10deg);
    background-color: #1dbc9c;
    padding: 60px
}

.error-wrapper .error-container .error {
    -webkit-transform: skew(0deg, 10deg);
    -moz-transform: skew(0deg, 10deg);
    -o-transform: skew(0deg, 10deg);
    -ms-transform: skew(0deg, 10deg);
    transform: skew(0deg, 10deg);
    margin: 0 auto;
    text-align: center;
    width: 350px
}

.error-wrapper .error-container .error .error-title {
    font-size: 28px;
    font-weight: 700;
    letter-spacing: 5px;
    text-transform: uppercase
}

.error-wrapper .error-container .error .error-number {
    font-size: 100px;
    font-weight: 700;
    letter-spacing: 5px;
    text-shadow: 0 3px 0 #292929, 0 14px 10px rgba(0, 0, 0, .15), 0 24px 2px rgba(0, 0, 0, .1), 0 34px 30px rgba(0, 0, 0, .1)
}

.error-wrapper .error-container .error .error-description {
    font-size: 14px;
    font-weight: 300;
    padding: 0 40px
}

.error-wrapper .error-container .error .error-or {
    height: 20px;
    margin: 30px 0 10px;
    position: relative;
    text-align: center
}

.error-wrapper .error-container .error .error-or .or-line {
    background-color: #169077;
    height: 1px;
    left: 40px;
    position: absolute;
    right: 40px;
    top: 10px
}

.error-wrapper .error-container .error .error-or .or {
    -lh-property: 0;
    left: -webkit-calc(50% - 30px);
    left: -moz-calc(50% - 30px);
    left: calc(50% - 30px);
    background-color: #1dbc9c;
    height: 20px;
    margin: 0 auto;
    position: absolute;
    text-transform: uppercase;
    top: 2px;
    width: 60px
}

.error-wrapper .error-container .error .error-textbox {
    padding: 0 40px
}

.error-wrapper .error-container .error .error-textbox .form-control {
    background-color: #292929;
    border: 0
}

.error-wrapper .error-container .error .error-submit {
    padding: 0 40px
}

.error-wrapper .error-container .error .error-submit input {
    font-size: 13px;
    font-weight: 300;
    text-transform: uppercase
}

.error-wrapper .error-container .error .error-actions {
    display: block;
    height: 40px;
    list-style: none;
    padding: 5px
}

.error-wrapper .error-container .error .error-actions>li {
    display: inline-block;
    float: left;
    width: 33%
}

.error-wrapper .error-container .error .error-actions>li a i {
    color: #292929;
    font-size: 32px
}

.error-wrapper .error-container.error-500 {
    background-color: #ffc107
}

.error-wrapper .error-container.error-500 .error .error-or .or-line {
    background-color: #d39e00
}

.error-wrapper .error-container.error-500 .error .error-or .or {
    background-color: #ffc107
}

.error-wrapper .error-container.error-401 {
    background-color: #34b5dc
}

.error-wrapper .error-container.error-401 .error .error-or .or-line {
    background-color: #2198bd
}

.error-wrapper .error-container.error-401 .error .error-or .or {
    background-color: #34b5dc
}

@media only screen and (max-width:600px) {
    .error-wrapper {
        padding-top: 5%
    }
    .error-wrapper .error-container {
        -webkit-transform: skew(0deg, -5deg);
        -moz-transform: skew(0deg, -5deg);
        -o-transform: skew(0deg, -5deg);
        -ms-transform: skew(0deg, -5deg);
        transform: skew(0deg, -5deg)
    }
    .error-wrapper .error-container .error {
        -webkit-transform: skew(0deg, 5deg);
        -moz-transform: skew(0deg, 5deg);
        -o-transform: skew(0deg, 5deg);
        -ms-transform: skew(0deg, 5deg);
        transform: skew(0deg, 5deg);
        width: auto
    }
}
</style>
</head>
<body>

<div class="error-wrapper">
    <div class="error-container">
        <div class="error">
            <div class="error-title">
                Error
            </div>
            <div class="error-number">
                404
            </div>
            <div class="error-description">
                Sorry, Your payment failed. Please Try Again
            </div>
            <div class="error-or">
                <div class="or-line"></div>
            </div>
            <div class="error-textbox">
                <a href="cart.php" class="btn btn-primary p-3 px-xl-4 py-xl-3">Back to Cart</a>
            </div>
            <ul class="error-actions">
                <li>
                    <a href="">
                        <i class="pe-7s-left-arrow" data-toggle="tooltip" title="" data-original-title="BACK"></i>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="pe-7s-home" data-toggle="tooltip" title="" data-original-title="HOME"></i>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="pe-7s-mail" data-toggle="tooltip" title="" data-original-title="CONTACT US"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>