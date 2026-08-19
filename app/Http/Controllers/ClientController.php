namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::select('id', 'name', 'email', 'client_type', 'credit_limit', 'current_encours', 'has_unpaid_bills')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $clients
        ]);
    }
}