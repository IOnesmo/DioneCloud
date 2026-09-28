<?php

namespace App\Http\Controllers;

use App\Models\LinkedAccount;
use Illuminate\Http\Request;

class AccountManagerController extends Controller
{
    public function index()
    {
        $accounts = LinkedAccount::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('account-manager', compact('accounts'));
    }

    public function updateCombined(Request $request)
    {
        $request->validate([
            'account_ids' => 'required|array',
            'account_ids.*' => 'integer|exists:linked_accounts,id',
        ]);

        LinkedAccount::where('user_id', auth()->id())->update(['is_combined' => false]);

        LinkedAccount::whereIn('id', $request->account_ids)
            ->where('user_id', auth()->id())
            ->update(['is_combined' => true]);

        return back()->with('success', 'Account selection updated successfully!');
    }

    public function removeAccount($id)
    {
        $account = LinkedAccount::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $account->delete();

        return back()->with('success', 'Account removed successfully!');
    }
}
