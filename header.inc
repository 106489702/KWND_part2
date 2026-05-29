<!DOCTYPE html>
<html lang = en>
  <head>
    <title>KWAND Creative</title>
    <meta charset="UTF-8">
    <meta name="description" content="About us page for our Creative Digital Media Agency">
    <meta name="keywords" content="Media,Digital Media,Web Design,Website Designer,Design,Designer,Brand,Branding,Digital,Team,About Us,Team Members,Digital Media Agency">
    <meta name="author" content="William Luck, Kerrigan La-Brooy Jr, Nguyen Pham, Duy">
    <!--CSS Style Sheet-->
    <link rel="stylesheet" href="styles/style.css">
  </head>
  <header>
      <div class="branding">
            <!-- Logo was created through use of GenAI -->
            <img src="images/logo.webp" alt="Kwnd Creative Logo" width="400px" id="logo">
            <h1 id="slogan">About KWND Creative</h1>
      </div>
      <?php include 'nav.inc'; ?> 
      <form id="searchForm" action="/search" method="get">
        <label for="site-search" id="search-label">Search the site:</label>
        <input type="search" id="site-search" placeholder="Search..."> 
        <button type="submit">Search</button>
      </form>
  </header>
  <body>