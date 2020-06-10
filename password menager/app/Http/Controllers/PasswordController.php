<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordStorageStoreRequest;
use App\Http\Requests\PasswordStorageUpdateRequest;
use App\Models\PasswordStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class PasswordController extends Controller
{
    /**
     * Index Page
     *
     * @return Factory|View
     */
    public function index()
    {
        $userPasswordStorage = PasswordStorage::where('user_id', request()->user()->id)->paginate(10);

        return view('passwords.index', compact('userPasswordStorage'));
    }

    /**
     * Create page
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('passwords.create');
    }

    /**
     * Store in DB
     *
     * @param PasswordStorageStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PasswordStorageStoreRequest $request)
    {
        $passwordStorage = PasswordStorage::create($request->all() + ['user_id' => $request->user()->id]);

        if($passwordStorage){
            return redirect()->route('passwords.index');
        } else{
            return redirect()->back();
        }
    }

    /**
     * Edit page
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit(int $id)
    {
        $passwordStorage = PasswordStorage::findOrFail($id);

        $this->authorizeForPasswordStorage($passwordStorage);

        return view('passwords.edit', compact('passwordStorage'));
    }

    /**
     * Update
     *
     * @param PasswordStorageUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(PasswordStorageUpdateRequest $request, int $id)
    {
        $passwordStorage = PasswordStorage::findOrFail($id);

        $this->authorizeForPasswordStorage($passwordStorage);

        $passwordStorage->update($request->all());

        if($passwordStorage){
            return redirect()->route('passwords.index');
        } else{
            return redirect()->back();
        }
    }

    /**
     * Delete
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id)
    {
        $passwordStorage = PasswordStorage::findOrFail($id);

        $this->authorizeForPasswordStorage($passwordStorage);

        $passwordStorage->delete();

        return redirect()->route('passwords.index');
    }

    private function authorizeForPasswordStorage($passwordStorage)
    {
        if(
            $passwordStorage !== null &&
            $passwordStorage->user_id !== request()->user()->id
        ){
            abort(403);
        }
    }
}
