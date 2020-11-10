<?php
    
?>
<body>
    <header>
        <img src="/img/Cabecalho.jpg" width=100% alt="" />
        <div class="fixed-top">
            <a href="/auth/login.html">
                <button id="btnLogin" class="btn btn btn-outline-dark btn-sm float-right" style="margin:50px 63px, position:absolute, top: 0">Logout</button>
            </a>
        </div>
        <nav id="navbar_top" class="navbar navbar-expand-md bg-dark navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/img/Logo.png" width="45" height="35" class="d-inline-block align-center" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto" id="navbar1">
                        <?php
                            foreach ($paginas as $key=>$value){
                                #Verificar se não é array
                                if(!is_array($value)){
                                    #Links
                                    echo '
                                    <li class="nav-item">
                                        <a class="nav-link" href="?page='.$key.'">
                                            '.ucfirst($key).'
                                        </a>
                                    </li>
                                    ';
                                } else{
                                    #Dropdown
                                    echo '<li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown">'.ucfirst($key).'</a>
                                        <div class="dropdown-menu" aria-labelledby="navbardrop">';
                                            foreach($value as $key_2=>$value_2){
                                                echo '<a class="dropdown-item" href="?page='.$key.'&subpage='.$key_2.'">'.ucfirst($key_2).'</a>';
                                            }
                                        echo '</div></li>';
                                }
                            }
                        ?>
                    </ul>
                    <div class="d-none d-md-block">
                        <form class="form-inline">
                            <input class="form-control mr-sm-2" type="search" placeholder="Pesquisar">
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
</body>

</html>