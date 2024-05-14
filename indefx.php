<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WEBSITES</title>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="vector.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Roboto:wght@100&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Open+Sans&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Allerta+Stencil&family=Open+Sans&family=Syncopate&display=swap');

    * {
      padding: 0;
      margin: 0;
      font-family: sans-serif;
      font-size: 14px;
      list-style: none;
      text-decoration: none;
      user-select: none;
    }

    html {
      font-size: 10px;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(90deg, #ffccff 50%, #80e5ff 50%);
    }

    body:before {
      content: "";
      position: absolute;
      top: 2rem;
      left: 2rem;
      z-index: -3;
      width: 8rem;
      height: 8rem;
      background: #fff;
      border-radius: 50%;
    }

    body:after {
      content: "";
      position: absolute;
      bottom: 1rem;
      left: 4rem;
      z-index: -3;
      width: 100px;
      height: 100px;
      background: #fff;
      border-radius: 50%;
    }

    .container {
      position: relative;
      display: grid;
      grid-template-columns: .1fr 1fr .1fr;
      grid-template-rows: .2fr 1fr .3fr;
      grid-template-areas: "header header header"
        "left body right"
        "footer footer footer";
      gap: 1rem;
      padding: 1rem;
      width: 90%;
      min-height: 85vh;
      background: linear-gradient(90deg, #80e5ff 50%, #ffccff 50%);
      box-shadow: 5px 5px 5px rgba(16, 16, 16, .1),
        10px 10px 10px rgba(16, 16, 16, .1),
        15px 15px 15px rgba(16, 16, 16, .1),
        20px 20px 20px rgba(16, 16, 16, .1),
        25px 25px 25px rgba(16, 16, 16, .1);
      overflow: hidden;
    }

    /* DONUT-IMG CSS*/

    .donut-img {
      position: absolute;
    }

    .donut-img img {
      width: 10rem;
      height: 10rem;
      transform: translateY(-80rem);
      z-index: -2;
      animation: anime 20s linear infinite;
      padding: 0 5rem;
      animation-delay: calc(-12s*var(--i));
    }

    @keyframes anime {
      to {
        transform: translateY(80rem) rotate(360deg);
      }
    }

    /* DONUT-IMG CSS END*/

    .container:before {
      content: "";
      position: absolute;
      bottom: 1rem;
      left: -3.5rem;
      width: 6rem;
      height: 6rem;
      background: #ffccff;
      border-radius: 50%;
    }

    .container:after {
      content: "";
      position: absolute;
      top: -2rem;
      right: -2rem;
      width: 12rem;
      height: 12rem;
      background: #80e5ff;
      border-radius: 50%;
    }


    .container .bg {
      background: rgba(255, 255, 255, .1);
    }

    .header {
      grid-area: header;
      z-index: 1;
    }

    .left-content {
      grid-area: left;
    }

    .main-body {
      grid-area: body;
    }

    .right-content {
      grid-area: right;
    }

    .footer {
      grid-area: footer;
    }

    /* HEADER CSS START */
    .container .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 2rem;
    }

    .container .header .logo img {

      width: 4rem;
      height: 5rem;
    }

    .container .header .navbar li .fa {
      color: #fff;
      font-size: 3.5rem;
      padding: 0 2rem;
      text-shadow: 1px 1px 1px rgba(16, 16, 16, .1),
        2px 2px 2px rgba(16, 16, 16, .1),
        3px 3px 3px rgba(16, 16, 16, .1),
        4px 4px 4px rgba(16, 16, 16, .1),
        5px 5px 5px rgba(16, 16, 16, .1);
    }

    .container .header .navbar li {
      display: inline-block;
    }

    .container .header .navbar li a {
      text-transform: capitalize;
      color: #fff;
      padding: 0 2rem;
      font-size: 1.6rem;
      font-weight: 700;
      text-shadow: 1px 1px 1px rgba(16, 16, 16, .1),
        2px 2px 2px rgba(16, 16, 16, .1),
        3px 3px 3px rgba(16, 16, 16, .1),
        4px 4px 4px rgba(16, 16, 16, .1),
        5px 5px 5px rgba(16, 16, 16, .1);
    }

    .container .header .navbar .cart {
      position: relative;
    }

    .container .header .navbar .cart span {
      position: absolute;
      top: -.5rem;
      right: .8rem;
      width: 1.5rem;
      height: 1.5rem;
      background: #fff;
      border-radius: 50%;
      text-align: center;
      color: #cacaca;
      box-shadow: 1px 1px 1px rgba(16, 16, 16, .1),
        2px 2px 2px rgba(16, 16, 16, .1),
        3px 3px 3px rgba(16, 16, 16, .1);
    }

    /* HEADER CSS END */

    /* LEFT-CONTENT CSS START*/
    .left-content {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .icons {
      position: relative;
      bottom: 4rem;
    }

    .icons .fa {
      margin: 1.5rem;
      color: #fff;
      font-size: 2.5rem;
      text-shadow: 1px 1px 1px rgba(16, 16, 16, .1),
        2px 2px 2px rgba(16, 16, 16, .1),
        3px 3px 3px rgba(16, 16, 16, .1),
        4px 4px 4px rgba(16, 16, 16, .1),
        5px 5px 5px rgba(16, 16, 16, .1);
      transition: .3s;
    }

    .icons .fa:hover {
      transform: rotate(360deg) scale(1.5);
      color: #000;
    }

    .icons span {
      position: absolute;
      left: 2.5rem;
      width: .2rem;
      height: 8rem;
      background: #fff;
      box-shadow: 5px 5px 5px rgba(16, 16, 16, .3);
      transition: .3s;
    }

    /* LEFT-CONTENT CSS END*/

    /* BODY CSS START */
    .main-body {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container .heading {
      text-align: center;
      color: #fff;
      text-shadow: 1px 1px 1px rgba(16, 16, 16, .1),
        2px 2px 2px rgba(16, 16, 16, .1),
        3px 3px 3px rgba(16, 16, 16, .1),
        4px 4px 4px rgba(16, 16, 16, .1),
        5px 5px 5px rgba(16, 16, 16, .1);

    }

    .container .heading .h2 span {
      font-size: 16rem;
      letter-spacing: 3rem;
      text-transform: uppercase;
      font-family: 'Allerta Stencil', sans-serif;
      font-weight: normal;
    }

    .container .heading .h1 {
      position: absolute;
      top: 3rem;
      left: 3rem;
      font-size: 3rem;
      font-family: 'Roboto', sans-serif;
    }

    .container .heading .h3 {
      position: absolute;
      bottom: 3rem;
      right: 3rem;
      font-size: 3rem;
      color: #fff;
      font-family: 'Roboto', sans-serif;
    }

    /* BODY CSS END */

    /* RIGHT-CONTENT CSS START*/

    .right-content {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .slider {
      position: relative;
      top: 4rem;
    }

    .slider li {
      margin: 2rem;
    }

    .slider li .fa {
      color: #fff;
      text-shadow: 1px 1px 1px rgba(16, 16, 16, .1),
        2px 2px 2px rgba(16, 16, 16, .1),
        3px 3px 3px rgba(16, 16, 16, .1),
        4px 4px 4px rgba(16, 16, 16, .1),
        5px 5px 5px rgba(16, 16, 16, .1);
      transition: .5s;
    }


    .slider span {
      position: absolute;
      top: -8rem;
      right: 2.5rem;
      width: .2rem;
      height: 8rem;
      background: #fff;
      box-shadow: 5px 5px 5px rgba(16, 16, 16, .3);
    }

    /* RIGHT-CONTENT CSS START*/

    /* FOOTER CSS START*/

    .footer {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .content {
      position: absolute;
      top: 1rem;
    }

    .content p {
      color: #fff;
      font-size: 1.8rem;
      font-family: 'Open Sans', sans-serif;
    }

    .content span {
      position: absolute;
      left: 46rem;
      bottom: 1rem;
      width: 5rem;
      height: .2rem;
      background: #fff;
      box-shadow: 5px 5px 5px rgba(16, 16, 16, .3);
    }

    .button {
      position: absolute;
      bottom: 3rem;
    }

    .button a {
      background: #fff;
      color: #000;
      text-transform: uppercase;
      font-size: 1.4rem;
      text-shadow: 1px 1px 1px #d1d9e6,
        1px 1px 2px #d1d9e6,
        3px 3px 3px #d1d9e6,
        4px 4px 4px #d1d9e6,
        5px 5px 5px #d1d9e6;
      box-shadow: 1px 1px 1px rgba(16, 16, 16, .1),
        2px 2px 2px rgba(16, 16, 16, .1),
        3px 3px 3px rgba(16, 16, 16, .1),
        4px 4px 4px rgba(16, 16, 16, .1),
        5px 5px 5px rgba(16, 16, 16, .1);
      font-family: 'Open Sans', sans-serif;
      text-decoration: none;
      padding: .5rem 3rem;
      border-radius: 3rem;
      transition: .3s;
    }

    /* FOOTER CSS END*/

    @media screen and (max-width: 1024px) {
      html {
        font-size: 9.5px;
      }
    }

    @media screen and (max-width: 936px) {
      html {
        font-size: 9px;
      }
    }

    @media screen and (max-width: 888px) {
      html {
        font-size: 8.5px;
      }
    }

    @media screen and (max-width: 840px) {
      html {
        font-size: 7.8px;
      }
    }

    @media screen and (max-width: 768px) {
      html {
        font-size: 7px;
      }

      body {
        background: linear-gradient(90deg, #fff 50%, #000 50%);
      }

      .container {
        background: linear-gradient(90deg, #000 50%, #fff 50%);
      }

      .slider li .fa {
        color: #000;
      }

      .slider span {
        background: #000;
      }

      .h3 {
        color: #000;
      }

      .container .header .navbar li a {
        color: #000;
      }

      body:before {
        background: #000;
      }

      .container .bg {
        background: rgba(16, 16, 16, .05);
      }

      .left-content .fa:hover {
        color: #fff;
      }

      .container .heading .h2 span {
        display: flex;
        flex-direction: column;
        font-size: 8rem;
      }

      .content {
        top: 3rem;
      }
    }

    @media screen and (max-width: 540px) {
      .container .header .navbar li a {
        color: #fff;
      }

      .container .bg {
        backdrop-filter: blur(5px);
      }
    }
  </style>
</head>

<body>
  <div class="container">

    <div class="donut-img">
      <img style="--i:0" src="d1.png" alt="">
      <img style="--i:1" src="d2.png" alt="">
      <img style="--i:2" src="d3.png" alt="">
      <img style="--i:3" src="d5.png" alt="">
      <img style="--i:4" src="d6.png" alt="">
      <img style="--i:5" src="d7.png" alt="">
    </div>

    <div class="header bg">
      <div class="logo">
        <img width="50px" height="60px" src="logo7.png" alt="">
      </div>

      <div class="navbar">
        <li><a class="home" href="#">home</a></li>
        <li><a href="#">menu</a></li>
        <li><a href="#">contact</a></li>
        <li class="cart">
          <i class="fa fa-shopping-cart"></i>
          <span>1</span>
        </li>
      </div>
    </div>


    <div class="left-content bg">
      <div class="icons">
        <li><i class="fa fa-facebook"></i></li>
        <li><i class="fa fa-instagram"></i></li>
        <li><i class="fa fa-twitter"></i></li>
        <span class="hover"></span>
      </div>
    </div>

    <div class="main-body bg">
      <h1 class="heading">
        <span class="h1">The</span>
        <span class="h2">
          <span style="--i:0">s</span>
          <span style="--i:1">w</span>
          <span style="--i:2">e</span>
          <span style="--i:3">e</span>
          <span style="--i:4">t</span>
        </span>
        <span class="h3">Tooth</span>
      </h1>
    </div>

    <div class="right-content bg">
      <div class="slider">
        <span></span>
        <li><i class="fa fa-dot-circle-o"></i></li>
        <li><i class="fa fa-circle"></i></li>
        <li><i class="fa fa-circle"></i></li>
        <li><i class="fa fa-circle"></i></li>
      </div>
    </div>

    <div class="footer bg">
      <div class="content">
        <p>Enjoy will have you sippin' & slurpin & gorgin' & more</p>
        <span></span>
      </div>

      <div class="button">
        <a href="#">explore full range</a>
      </div>
    </div>
  </div>
</body>

</html>