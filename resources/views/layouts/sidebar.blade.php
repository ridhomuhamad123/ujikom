<div class="sidebar">
    <i class="fa fa-cash-register fa-2x me-2"></i>
    @if(Auth::user()->role  == 'admin')
    <span class="fs-5 fw-bold">Admin App</span>
    @endif
    @if(Auth::user()->role  == 'petugas')
    <span class="fs-5 fw-bold">Kasir App</span>
    @endif
    <hr>

    @auth
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link text-white">
                <i class="fa fa-home me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('products.index') }}" class="nav-link text-white">
                <i class="fa fa-box me-2"></i> Product
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('purchases.index') }}" class="nav-link text-white">
                <i class="fa fa-shopping-cart me-2"></i> Pembelian
            </a>
        </li>
        
        @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link text-white">
                <i class="fa fa-users me-2"></i> User
            </a>
        </li>
        @endif
    </ul>
    
    <hr>
    <div>
        <form action="{{ route('logout') }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-link text-white text-decoration-none">
                <i class="fa fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>
    @endauth
</div>