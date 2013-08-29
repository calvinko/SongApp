<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    
</head>

<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">      
                <ul class="nav">
                    <li id="nav-home"><a class="brand" href="./index.php"><i style="color:orangered" class="icon-home"></i></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span id="booktitle">Oakland 詩歌 1</span>
                            <i class="caret"></i>
                        </a>
                        <ul id="nav-songbook" class="dropdown-menu">
                            <li><a bookid="31" href="#">Oakland 詩歌 1</a></li>
                            <li><a bookid="32" href="#">Oakland 詩歌 2</a></li>
                            <li><a bookid="33" href="#">Oakland 詩歌 3</a></li>
                            <li><a bookid="101" href="#">English Song 1</a></li>
                            <li><a bookid="105" href="#">Sac Songbook - Butterfly</a></li>
                            <li><a bookid="11" href="#">神家詩歌 1</a></li>
                            <li><a bookid="12" href="#">神家詩歌 2</a></li>
                            <li><a bookid="13" href="#">神家詩歌 3</a></li>
                            <li><a bookid="14" href="#">神家詩歌 4</a></li>
                            <li><a bookid="15" href="#">神家詩歌 5</a></li>
                            <li><a bookid="16" href="#">神家詩歌 6</a></li>
                            <li><a bookid="17" href="#">神家詩歌 7</a></li>
                            <li><a bookid="18" href="#">神家詩歌 8</a></li>
                            <li><a bookid="19" href="#">神家詩歌 9</a></li>
                            <li><a bookid="20" href="#">神家詩歌 10</a></li>
                            <li><a bookid="21" href="#">神家詩歌 11</a></li>

                        </ul>
                    </li>
                            
                    <li><a id ="btincfont"><i class="icon-font"></i><i class="icon-caret-up"></i></a></li>
                    <li><a id ="btdecfont"><i class="icon-font"></i><i class="icon-caret-down"></i></a></li>
                </ul>
                <ul class="nav pull-right">
                    <li><a class="ktooltip" data-toggle="tooltip" title="Index" onclick="setcookie('church','oakland',100)">Setting</a></li>
                    <li id="nav-user" class="dropdown invisible">

                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="icon-user"></i> 
                                            Calvin Ko
                                            <b class="caret"></b>
                                    </a>

                                    <ul class="dropdown-menu">
                                            <li><a href="javascript:;"><i class="icon-user"></i>&nbsp Profile</a></li>
                                            
                                            <li class="divider"></li>
                                            <li><a href="logout.php"><i class="icon-signout"></i>&nbsp Logout</a></li>
                                    </ul>

                            </li>
                     <li id="nav-login"><a href="login.php">Login</a></li>
                </ul>
            </div>
    
    
    
</body>
    
    
    
</html>