<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset('administration/imgs/avatar_48dp.png') }}" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">{{ config('app.name') }}</p>
          <p class="app-sidebar__user-designation">Administration</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="{{ route('admin.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Tableau de bord</span></a></li>
          {{--<!-- PRODUITS -->
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-gift"></i><span class="app-menu__label">Produits</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="{{ route('admin.products.index') }}"><i class="icon fa fa-circle-o"></i> Liste des produits</a></li>
              <li><a class="treeview-item" href="{{ route('admin.products.create') }}"><i class="icon fa fa fa-plus"></i> Créer un produit</a></li>
            </ul>
          </li>
          <!-- CATEGORIES -->
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-folder"></i><span class="app-menu__label">Catégories</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="{{ route('admin.categories.index') }}"><i class="icon fa fa-circle-o"></i> Liste des catégories</a></li>
              <li><a class="treeview-item" href="{{ route('admin.categories.create') }}"><i class="icon fa fa fa-plus"></i> Créer une catégorie</a></li>
            </ul>
          </li>
          <!-- MARQUES -->
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-tag"></i><span class="app-menu__label">Marques</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="{{ route('admin.brands.index') }}"><i class="icon fa fa-circle-o"></i> Liste des marques</a></li>
              <li><a class="treeview-item" href="{{ route('admin.brands.create') }}"><i class="icon fa fa fa-plus"></i> Créer une marque</a></li>
            </ul>
          </li>
          <!-- COMMANDES -->
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-tag"></i><span class="app-menu__label">Commandes</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="{{ route('admin.orders.pending') }}"><i class="icon fa fa-circle-o"></i> Commandes en cours</a></li>
              <li><a class="treeview-item" href="{{ route('admin.orders.index') }}"><i class="icon fa fa-circle-o"></i> Liste des commandes</a></li>
            </ul>
          </li>--}}
      </ul>
    </aside>
