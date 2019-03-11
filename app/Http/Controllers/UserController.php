<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;

class UserController extends Controller
{
    private $view;
    private $response;

    /**
     * Constructor.
     * @param ViewFactory     $view
     * @param ResponseFactory $response
     */
    public function __construct(ViewFactory $view, ResponseFactory $response)
    {
        $this->view = $view;
        $this->response = $response;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return $this->view->make('users.show', [
            'user' => $request->user()
        ]);
    }

    public function update(UpdateCustomerRequest $request) {
        $request->user()->update($request->validated());
        return redirect()->route('user')->with('success', 'Shipping informations updated successfully.');
    }
}
