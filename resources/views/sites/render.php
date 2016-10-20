<html>
    <head>
        <link rel="stylesheet" href="<?php echo $css; ?>">
    </head>
    <body>
        <div class="header">
            <div class="site-banner">
                <img src="<?php echo $bannerimage; ?>">
            </div>
            <div class="site-name">
                <h1><?php echo $name; ?></h1>  
            </div>
        </div>
        <div class="navigation">
            <ul>
                <?php foreach ($navigation as $slug => $name) { ?>
                <li>
                    <a href="<?php echo $slug; ?>"><?php echo $name; ?></a>
                </li>
               <?php } ?>
            </ul>   
        </div>
        <div class="content">
            <h2><?php echo $page['title']; ?></h2>
            <p>
               <?php echo $page['content']; ?> 
            </p>
        </div>
        <div class="footer">
            footer 
        </div>
    </body>
</html>