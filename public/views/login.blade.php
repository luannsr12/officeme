<!-- header -->
@include('inc.header')

<body style="background-image: url('public/assets/img/login-fundo.png');background-size:cover;" >
  
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8 bg-white">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-primary text-gradient">Bem vindo de volta</h3>
                  <p class="mb-0">Digite seu usuário e senha para entrar</p>
                </div>
                <div class="card-body">
                  <form role="form">
                    <label>Usuário</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" placeholder="usuário" id="username" aria-label="usuário" aria-describedby="user-addon">
                    </div>
                    <label>Senha</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" placeholder="********" id="password" aria-label="Senha" aria-describedby="password-addon">
                    </div>
           
                    <div class="text-center">
                      <button type="button" id="btnLogin" class="btn bg-gradient-primary w-100 mt-4 mb-0">Entrar</button>
                    
                    </div>
                  </form>
                </div>
                
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- footer --> 
  @include('inc.footer')
</body>

</html>