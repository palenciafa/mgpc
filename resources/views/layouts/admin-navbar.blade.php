<!-- for admin navigation -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Panel</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('sales.index') }}">Sales</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('stock_logs.index') }}">Stock Logs</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
    </ul>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
  </div>
</nav>
