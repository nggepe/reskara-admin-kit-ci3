<style>
  body {
    padding: 0;
    margin: 0;
  }

  .error-wall {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    text-align: center;
    z-index: 9999999;
  }

  .error-wall.load-error {
    background-color: #5ea6f3;
  }

  .error-wall.matinence {
    background-color: #a473b1;
  }

  .error-wall.missing-page {
    background-color: #00bbc6;
  }

  .error-wall .error-container {
    display: block;
    width: 100%;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
  }

  .error-wall .error-container h1 {
    color: #fff;
    font-size: 80px;
    margin: 0;
  }

  @media (max-width: 850px) {
    .error-wall .error-container h1 {
      font-size: 65px;
    }
  }

  .error-wall .error-container h3 {
    color: #464444;
    font-size: 34px;
    margin: 0;
  }

  @media (max-width: 850px) {
    .error-wall .error-container h3 {
      font-size: 25px;
    }
  }

  .error-wall .error-container h4 {
    margin: 0;
    color: #fff;
    font-size: 40px;
  }

  @media (max-width: 850px) {
    .error-wall .error-container h4 {
      font-size: 35px;
    }
  }

  .error-wall .error-container p {
    font-size: 15px;
  }

  .error-wall .error-container p:first-of-type {
    color: #464444;
    font-weight: lighter;
  }

  .error-wall .error-container p:nth-of-type(2) {
    color: #464444;
    font-weight: bold;
  }

  .error-wall .error-container p.type-white {
    color: #fff;
  }

  @media (max-width: 850px) {
    .error-wall .error-container p {
      font-size: 12px;
    }
  }

  @media (max-width: 390px) {
    .error-wall .error-container p {
      font-size: 10px;
    }
  }
</style>
<div class="error-wall load-error">
  <div class="error-container">
    <h1>Oops!</h1>
    <h3>We have had an error</h3>
    <h4>Error 401</h4>
    <p>Sorry...There is no authorization of you!</p>
    <p>You can go back <a href="javascript:history.go(-1)">here</a></p>
  </div>
</div>