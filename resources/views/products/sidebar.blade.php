<div class="col-lg-3 float-md-right">
    <div class="categories_sidebar">
        <aside class="l_widgest l_p_categories_widget">
            <div class="l_w_title">
                <h3>Departments</h3>
            </div>
            <ul class="navbar-nav">
                @foreach($DEPARTMENTS as $department)
                    <li class="nav-item">
                        <a class="nav-link {{ $department->id === $currentDepartment->id ? 'font-weight-bold' : '' }}"
                           href="{{ route('departments.show', $department) }}">{{ $department->name }}</a>
                    </li>
                @endforeach
            </ul>
        </aside>
        <div class="categories_sidebar">
            <aside class="l_widgest l_p_categories_widget">
                <div class="l_w_title">
                    <h3>{{ $currentDepartment->name }} - Categories</h3>
                </div>
                <ul class="navbar-nav">
                    @foreach($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </aside>
            {{--<aside class="l_widgest l_fillter_widget">
                <div class="l_w_title">
                    <h3>Filter section</h3>
                </div>
                <div id="slider-range" class="ui_slider"></div>
                <label for="amount">Price:</label>
                <input type="text" id="amount" readonly>
            </aside>--}}
            {{--<aside class="l_widgest">
                <div class="l_w_title">
                    <h3>Filter price</h3>
                </div>
                <table>
                    <tr>
                        <th class="pr-2">
                            <label for="" class="control-label pr-2">Min&nbsp;:&nbsp;</label>
                        </th>
                        <td>
                            <input type="text" class="form-control" id="" value="0">
                        </td>
                    </tr>
                    <tr>
                        <th class="pr-2">
                            <label for="" class="control-label pr-2">Max&nbsp;:&nbsp;</label>
                        </th>
                        <td>
                            <input type="text" class="form-control" id="" value="0">
                        </td>
                    </tr>
                </table>
            </aside>
            @foreach($attributes as $attribute)
                @if($attribute->values->count() > 0)
                    <aside class="l_widgest">
                        <div class="l_w_title">
                            <h3>{{ $attribute->name }}</h3>
                        </div>
                        <ul>
                            @foreach($attribute->values as $value)
                                <li><a href="#">{{ $value->value }}</a></li>
                            @endforeach
                        </ul>
                    </aside>
                @endif
            @endforeach--}}
            @if($featured_products)
                <aside class="l_widgest l_feature_widget">
                    <div class="l_w_title">
                        <h3>Featured Products</h3>
                    </div>
                    @foreach($featured_products as $product)
                        <div class="media">
                            <div class="d-flex">
                                <img
                                    src="{{ asset("/storage/product_images/$product->thumbnail") }}"
                                    alt="">
                            </div>
                            <div class="media-body">
                                <h4>{{ $product->name }}</h4>
                                <h5>${{ $product->discounted_price }}</h5>
                            </div>
                        </div>
                    @endforeach
                </aside>
            @endif
        </div>
    </div>
</div>
