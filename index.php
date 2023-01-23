<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <title>Document</title>

    <style>

        .navbar
        {
            font-size: 18px;
            padding: 20px;
            position: sticky;
            top: 0;
            border-bottom: 1px solid #404646;
        }

        .level
        {
            padding-top: 30px;
            padding-bottom: 30px;
        }

        @import url("https://fonts.googleapis.com/css?family=Open+Sans|Sacramento");
html {
  font-size: 14.5px;
}

body {
  font-family: "Open Sans", sans-serif;
  line-height: 1.45em;
  background-color: #f0f0f0;
  color: #404646;
}

* {
  box-sizing: border-box;
}

.main-container {
  margin: 1.6rem 0.8rem;
}

.grid-container {
  margin: auto;
  display: grid;
  grid-gap: 1.1312rem;
  grid-template-columns: repeat(auto-fit, 12.8rem);
  grid-auto-rows: 12.8rem;
  grid-auto-flow: dense;
  justify-content: center;
  max-width: 75em;
}

.card {
  grid-row: auto/span 1;
  grid-column: auto/span 1;
  background-color: white;
  box-shadow: 1px 3px 3px rgba(0, 10, 20, 0.06);
}
.card h1,
.card h2,
.card h3,
.card h4,
.card p {
  margin-top: 0;
  font-weight: normal;
}
.card__image {
  height: 100%;
  max-height: 100%;
  width: 100%;
  display: flex;
}
.card__image img {
  height: 100%;
  min-height: 100%;
  max-height: 100%;
  width: 100%;
  -o-object-fit: cover;
     object-fit: cover;
}
.card__side-by-side {
  height: 100%;
  width: 100%;
  display: flex;
  flex-flow: row nowrap;
}
.card__side-by-side--m {
  height: 100%;
  width: 100%;
  display: flex;
  flex-flow: column nowrap;
}
.card__side-by-side--m img {
  min-height: auto;
}
.card__content {
  padding: 1.6rem;
}
.card__button {
  margin: 1.6rem 0;
  text-align: center;
  padding: 0.8rem 1.6rem;
  background: none;
  border: 0.5px solid #777;
  border-radius: 2px;
}
.card__button:hover {
  border-color: #d099a0;
}
.card--featured {
  grid-row: auto/span 3;
  grid-column: auto/span 2;
}
.card--2x {
  grid-row: auto/span 2;
  grid-column: auto/span 2;
}
.card--vertical {
  grid-row: auto/span 2;
}
.card--horizontal {
  grid-column: auto/span 2;
}
.card--frameless {
  background-color: transparent;
  box-shadow: none;
}

.padding-large {
  padding: 3.2rem;
}
.padding-large--l {
  padding: 1.6rem;
}

.big-script {
  height: 100%;
  display: flex;
  flex-flow: column nowrap;
  justify-content: center;
  align-items: center;
  font-family: "Sacramento", sans-serif;
  font-size: 4.3em;
  line-height: 1.15em;
  text-align: center;
}
.big-script p {
  margin: 0;
}

@media (max-width: 413px) {
  .grid-container {
    grid-template-columns: 1fr 1fr;
    grid-auto-rows: auto;
  }

  .card {
    min-height: 12.8rem;
  }
}
@media (min-width: 627px) {
  .grid-container {
    grid-gap: 1.6rem;
  }

  .card__side-by-side--m {
    flex-flow: row nowrap;
  }
  .card__side-by-side--m img {
    min-height: 100%;
  }
  .card--featured {
    grid-row: auto/span 2;
    grid-column: 1/-1;
  }
}
@media (min-width: 836px) {
  .padding-large--l {
    padding: 3.2rem;
  }
}

a
{
  text-decoration:none;
  color:black;
}

    </style>
</head>
<body>

    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <figure class="image is-64x64">
                <img class="is-rounded" src="https://media.istockphoto.com/vectors/book-library-icon-vector-id1271769852?k=20&m=1271769852&s=170667a&w=0&h=dg56yyBI-6A-gvCDQYGimf5T_IlwCrkSuog2lT2J62o=">
              </figure>
      
          <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
          </a>
        </div>
      
        <div id="navbarBasicExample" class="navbar-menu">
          <div class="navbar-start">
            <a class="navbar-item" href="#TOP">
              Strona główna
            </a>
      
            <a class="navbar-item" href="regulamin.html">
              Regulamin
            </a>
      
            <div class="navbar-item has-dropdown is-hoverable">
              <a class="navbar-link">
                Więcej
              </a>
      
              <div class="navbar-dropdown">
                
                <a class="navbar-item" href="Contact/Strona-Główna.html">
                  Kontakt
                </a>
                
                
              </div>
            </div>
          </div>
      
          <div class="navbar-end">
            <div class="navbar-item">
              <div class="buttons">
                <a class="button is-primary" href="login/index2.php">
                  <strong>Zaloguj</strong>
                </a>
                <a class="button is-light" href="login/index.php">
                 Admin
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>

      <a name="TOP"></a>

      <div class='main-container'>
        <div class='grid-container'>
          <div class='card card--2x'>
            <div class='card__content big-script padding-large'>
              <p>Wiedza to potęga</p>
            </div>
          </div>
          <div class='card'>
            <div class='card__image'>
              <img src='https://cdn.pixabay.com/photo/2017/08/06/22/01/books-2596809_960_720.jpg'>
            </div>
          </div>
          <div class='card'>
            <div class='card__image'>
              <img src='https://zszdz.rzeszow.pl/images/glowne/156-5275.jpg'>
            </div>
          </div>
          <div class='card'>
            <div class='card__content'>
              <p><em>Zachęcamy do wypożyczeń nowego zestawu książek.</em></p>
              
            </div>
          </div>
          <div class='card card--horizontal'>
            <div class='card__image'>
              <img src='https://www.poznan.pl/mim/main/pictures/-,pic1,1016,154554,276112,with-ratio,16_9.jpg'>
            </div>
          </div>
          <div class='card card--featured'>
            <div class='card__side-by-side--m'>
              <div class='card__image'>
                <img src='https://nofluffjobs.com/blog/wp-content/uploads/2017/04/5_ksia%C5%BCek.png'>
              </div>
              <div class='card__content padding-large--l'>
                <h2>Quisque volutpat.</h2>
                <p>Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit.</p>
                <p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <div class='card__button'>More...</div>
              </div>
            </div>
          </div>
          <div class='card card--vertical'>
            <div class='card__image'>
              <img src='https://images.pexels.com/photos/920968/pexels-photo-920968.jpeg?auto=compress&amp;cs=tinysrgb&amp;h=750&amp;w=1260'>
            </div>
          </div>
          <div class='card'>
            <div class='card__image'>
              <img src='https://images.pexels.com/photos/386009/pexels-photo-386009.jpeg?auto=compress&amp;cs=tinysrgb&amp;h=750&amp;w=1260'>
            </div>
          </div>
          <div class='card card--horizontal'>
            <div class='card__side-by-side'>
              <div class='card__image'>
                <img src='https://images.pexels.com/photos/885880/pexels-photo-885880.jpeg?auto=compress&amp;cs=tinysrgb&amp;h=750&amp;w=1260'>
              </div>
              <div class='card__content'>
                <h3></h3>
                <p>Książki pozwalają na poznawanie nowych kultur</p>
              </div>
            </div>
          </div>
          <div class='card card--vertical'>
            <div class='card__image'>
              <img src='https://images.pexels.com/photos/450597/pexels-photo-450597.jpeg?auto=compress&amp;cs=tinysrgb&amp;h=750&amp;w=1260'>
            </div>
          </div>
          <div class='card'>
            <div class='card__image'>
              <img src='https://images.pexels.com/photos/269923/pexels-photo-269923.jpeg?auto=compress&amp;cs=tinysrgb&amp;h=750&amp;w=1260'>
            </div>
          </div>
          <div class='card'>
            <div class='card__content'>
              <p><em>Przewodniki są już dostępne na stronie biblioteki</em></p>
              <p></p>
            </div>
          </div>
          <div class='card card--2x'>
            <div class='card__image'>
              <img src='https://images.pexels.com/photos/247929/pexels-photo-247929.jpeg?auto=compress&amp;cs=tinysrgb&amp;h=750&amp;w=1260'>
            </div>
          </div>
          <div class='card card--horizontal card--frameless'>
            <div class='card__content big-script'>
              <p>Z książkami przez świat</p>
            </div>
          </div>
          <div class='card'>
            <div class='card__image'>
              <img src='https://images.pexels.com/photos/33545/sunrise-phu-quoc-island-ocean.jpg?auto=compress&amp;cs=tinysrgb&amp;h=750&amp;w=1260'>
            </div>
          </div>
          <div class='card card--horizontal'>
            <div class='card__image'>
              <img src='https://images.pexels.com/photos/358319/pexels-photo-358319.jpeg?auto=compress&amp;cs=tinysrgb&amp;h=750&amp;w=1260'>
            </div>
          </div>
          <div class='card'>
            <div class='card__image'>
              <img src='https://images.pexels.com/photos/373912/pexels-photo-373912.jpeg?auto=compress&amp;cs=tinysrgb&amp;h=750&amp;w=1260'>
            </div>
          </div>
          <div class='card'>
            <div class='card__content'>
              <p><em>„Nasza wiedza jest i będzie ograniczona. Nasza ignorancja jest i pozostanie nieograniczona i nieskończona.“</em></p>
              <p>— Karl Popper</p>
            </div>
          </div>
          <div class='card'>
            <div class='card__image'>
              <img src='https://images.pexels.com/photos/386007/pexels-photo-386007.jpeg?auto=compress&amp;cs=tinysrgb&amp;h=750&amp;w=1260'>
            </div>
          </div>
        </div>
      </div>


      <nav class="level is-mobile">
        <div class="level-item has-text-centered">
          <div>
            <p class="heading"><a href="http://twitter.com" target="blanket">Tweets</a> </p>
            <p class="title">3,456</p>
          </div>
        </div>
        <div class="level-item has-text-centered">
          <div>
            <p class="heading"><a href="http://twitter.com" target="blanket">Following</p>
            <p class="title">123</p>
          </div>
        </div>
        <div class="level-item has-text-centered">
          <div>
            <p class="heading"><a href="http://twitter.com" target="blanket">Followers</p>
            <p class="title">456K</p>
          </div>
        </div>
        <div class="level-item has-text-centered">
          <div>
            <p class="heading"><a href="http://twitter.com" target="blanket">Likes</p>
            <p class="title">789</p>
          </div>
        </div>
      </nav>
    
</body>
</html>