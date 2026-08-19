namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ODataController extends Controller
{
    public function getProducts()
    {
        $response = Http::get('https://TON_SERVEUR_ODATA.com/odata/v4/Clients');

        $data = $response->json()['value'] ?? [];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
