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