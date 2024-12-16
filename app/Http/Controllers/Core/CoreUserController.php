<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Core\CoreUserRequest;
use App\Repositories\Core\CoreUserRepository;
use App\Models\Core\CoreGroup;
use App\Models\Core\CoreUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CoreUserController extends BaseController
{
    public function index(Request $request)
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $coreUsers = CoreUser::get();
        return view('core.users.index', compact('coreUsers'));
    }

    public function ajax(Request $request)
    {
        if (empty($this->chars)) return redirect('/no_permission');

        $dataTable = (new CoreUserRepository(new CoreUser))->getDataTablesFiltered($request);
        $index = 0;
        $items = [];
        foreach ($dataTable->items as $item) {

            $items[$index] = [
                $item->username,
                $item->surname,
                $item->name,
                $item->email,
                $item->coreGroup->name . ($item->permissionExceptions()->exists()? '+Eccezioni' :''),
                $item->active,
            ];

            if (in_array('E', $this->chars)) {
                array_push(
                    $items[$index],
                    "<a href=\"" . route('core_users.edit', $item) . "\" class='btn btn-xs btn-info' title='Modifica'>
                        <i class='fas fa-edit'></i>
                    </a>"
                );
            }
            if (in_array('V', $this->chars)) {
                array_push(
                    $items[$index],
                    "<a href=\"" . route('core_users.show', $item) . "\" class='btn btn-xs btn-primary' title='Visualizza'>
                        <i class='fas fa-eye'></i>
                    </a>"
                );
            }
            if (in_array('L', $this->chars)) {
                array_push(
                    $items[$index],
                    "<button onclick='coreUserLockItem(this)' title='" . ($item->active == 1 ? 'Nascondi' : 'Mostra') . "'
                            data-id='" . $item->id . "' data-current='" . $item->active . "'  type='button'
                            class='action_block btn btn-xs btn-" . ($item->active == 1 ? 'warning' : 'primary') . "'>
                        <i class='fa fa-" . ($item->active == 1 ? 'lock' : 'unlock') . "'></i>
                    </button>"
                );
            }
            if (in_array('D', $this->chars)) {
                array_push(
                    $items[$index],
                    "<button onclick='coreUserDeleteItem(this)' data-id=\"" . $item->id . "\" type='button'
                            class='action_del btn btn-xs btn-danger' title='Elimina'>
                        <i class='fa fa-trash'></i>
                    </button>"
                );
            }

            $index++;
        }

        return response()->json([
            'start' => $request->start,
            'length' => $request->length,
            'draw' => $request->draw,
            'recordsTotal' => $dataTable->recordsTotal,
            'recordsFiltered' => $dataTable->recordsFiltered,
            "data" => $items,
        ]);
    }

    public function create()
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        $coreGroups = CoreGroup::orderBy('name', 'asc')->get();
        return view('core.users.create', compact('coreGroups'));
    }

    public function store(CoreUserRequest $request)
    {
        if (!in_array('A', $this->chars)) return redirect('/no_permission');

        CoreUser::create([
            'core_group_id' => $request->core_group_id,
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
            'surname' => $request->surname,
            'active' => $request->active,
            'password' => $request->password ?? Str::random(10),
        ]);

        Session::flash('success', 'L\'utente è stato aggiunto!');
        return redirect()->route('core_users.index');
    }

    public function show(CoreUser $coreUser)
    {
        if (!in_array('V', $this->chars)) return redirect('/no_permission');

        return view('core.users.show', compact('coreUser'));
    }

    public function edit(CoreUser $coreUser)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreGroups = CoreGroup::orderBy('name', 'asc')->get();
        return view('core.users.edit', compact('coreGroups', 'coreUser'));
    }

    public function update(CoreUserRequest $request, CoreUser $coreUser)
    {
        if (!in_array('E', $this->chars)) return redirect('/no_permission');

        $coreUser->update([
            'core_group_id' => $request->core_group_id,
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
            'surname' => $request->surname,
            'active' => $request->active,
        ]);

        Session::flash('success', 'Le modifiche sono state correttamente salvate!');
        return redirect()->route('core_users.index');
    }

    public function lock(Request $request, CoreUser $coreUser)
    {
        if (!in_array('L', $this->chars)) return redirect('/no_permission');

        $coreUser->update([
            'active' => !$request->lock,
        ]);

        return response()->json(['status' => 'Success'], 200);
    }

    public function destroy(CoreUser $coreUser)
    {
        if (!in_array('D', $this->chars)) return redirect('/no_permission');

        $coreUser->delete();

        return response()->json(['status' => 'Success'], 204);
    }
}
