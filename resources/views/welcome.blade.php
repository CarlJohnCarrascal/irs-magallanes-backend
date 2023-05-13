<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="/favicon.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="manifest" href="/manifiest.json">
  <link rel="apple-touch-icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAIAAABt+uBvAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAASESURBVHhe7ZZJchw5EAT1EB31/5/NG6g0ppMCvfbGUujucfOLJgMoZBjF0a+PUfz3+0/Kn5+EEQV9V/Mtg2egb0HqpZTE9PQqSHUsJTc97QtSETtyYG5aFqT9z8jJiWlTkNZeuhXL/z4ztQVp4aXkvtA0ZDArDxakJVclukCxkMGUXC5Iu61KdAOFQwZTcqEgbbUq0SN0KmQwH6cK0jKrEj2NjocMJuOgIO2wKtGL6JKQwWRsFqTXr0r0UXRbyGAmVgrSo1clWo2uDRlMw4+C9Nal5JqiT4QM5oCC9MSlGeuBPhQymINfetxSgj3RF0MGE7BXEJEh6NMhg7tZL4jhQPSAkMHdbP4EMR+IHhAyuJWD30GkRqGvhwzu4/j/YhkYgz4dMriPf/8O0sskof7ouyGDm/C/pPW4UhL90XdDBnfgggI9ThLqib4YMriDlYISPVES6oY+FzIYzmZBiV5ZSqIb+lzIYCwHBQV6pSTUDt1fSmIsxwUleqskVIfuXEpuLGcLSvTiUhKPotuWkhvOtYICvVsSuo7uKSVxE5cLSrRDKYmL6JKU2a08WFCifUpJXEE3pMzuo6qgQPtIQqfR8ZTZTdQWlGilUhKn0fGU2R20KSjQSpLQOXQ2ZTacZgUl2qqUxDl0NmU2lsYFBdrqW8an0fGU2UBaFqRlJKEr6IaU2Si6/5JOyV1H96TMhlBbkJ6+lFwFujBl1p+qgvRoSagFujll1pkuBTFuij6RMutJr58gEk3RJ1Jm3ej7O4hQO3R/yqwPtQUlenEpiXbo/pRZB9oUFOjFklAjdHnKrDXNCkr06FISjdDlKbOmNC4o0KMloRbo5pRZO9oXlOjdklA1ujZl1oheBSV6eimJanRtyqwFfQsK9HRJqA7dmTKrpntBiV5fSuIhdFUpiWoGFRRoAUnoNDq+lFw14wpKtIYkdIROLSXXgtEFJdqnlMQuOlJKoh33FBRoMUloA4VTZq25raBES5aS2EDhkEFrbi4o0aqlJNZQMmTQlCkKCrRqKYkFiqXM2jFLQYFW/ZbxGkqGDNox+1+xkNAGCocMGjHvL+mU3C46EjJowZ0FaStJ6AQ6mDKrZsaCGF9BN4QMqpn0J4jEFXRDyKCOeX8HkTiNjqfMKri5oERblZI4h86GDCqYoqBAi0lCJ9DBkMGjzFJQot1KSZxAB0MGDzFXQYF2k4R20ZGU2XWmKyjRepLQNsqHDK4zaUGJliwlsY3yIYOLTF1QoCUloQ0UDhlcYfaCEu1ZSmINJVNmp3mOggLtKQktUCxkcJqnKSjRtpLQT5QJGZzjyQpKtHApiZ8oEzI4wVMWFGhhSegLTVNmRzxrQYl2loQ+0ShkcMRzF5Ro81ISn2gUMtjlFQoKtLkk9FBHL1JQouVLdwI52uKlCgq0vFwN5MEtXq2gRBUcyrE1XrOgRC3sy5kFr1xQoBZ25MCCFy8oURdbkv7JWxSUqI5ViRa8UUGB6liV6BfvVVCiRiShL96xoEClSEKfvGlBiXopJfHmBSWqJmX2f0GJ2gkZfHz8BUqmC0D8meXTAAAAAElFTkSuQmCC">
  <meta name="apple-mobile-web-app-status-bar" content="#aa7700">

  <title>IRS - Magallanes</title>
  <style>
    #loader {
      border: 12px solid #f3f3f3;
      border-radius: 50%;
      border-top: 12px solid #444444;
      width: 70px;
      height: 70px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      100% {
        transform: rotate(360deg);
      }
    }

    .center {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      margin: auto;
    }
  </style>
  <script>
    document.onreadystatechange = function () {
      if (document.readyState !== "complete") {
        document.querySelector(
          "body").style.height = "1vh";
        document.querySelector(
          "body").style.visibility = "hidden";
        document.querySelector( 
          "#loader").style.visibility = "visible"; 
      } else {
        document.querySelector(
          "#loader").style.display = "none";
        document.querySelector(
          "body").style.visibility = "visible";
      }
    };
  </script>
  <script type="module" crossorigin src="../assets/index-90e80c42.js"></script>
  <link rel="stylesheet" href="../assets/index-3160904d.css">
</head>
<div style="height: 1px;">
  <div id="loader" class="center">
  </div>
</div>
<body id="page-top" class="overflow-auto h-auto">
  <div id="app"></div>
  

</body>

</html>