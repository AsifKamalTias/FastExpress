<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand fs-3 text-success" href="{{route('home')}}">FastExpress</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{route('home')}}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('blogs')}}">Blogs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{route('client.profile')}}">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('client.get-out')}}">Get out</a>
          </li>
        </ul>
        </div>
      </div>
    </div>
  </nav>