<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rental;
use App\Models\User;
use App\Models\Newsletter;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch data dynamically
        $totalEvents = Event::count();
        $eventChange = $this->calculateChange(Event::class);

        $totalRentals = Rental::count();
        $rentalChange = $this->calculateChange(Rental::class);

        $totalUsers = User::count();
        $userChange = $this->calculateChange(User::class);

        $totalNews = Newsletter::count();
        $newsChange = $this->calculateChange(Newsletter::class);

        // Pass data to the view
        return view('dashboard.main', compact('totalEvents', 'eventChange', 'totalRentals', 'rentalChange', 'totalUsers', 'userChange', 'totalNews', 'newsChange'));
    }

    private function calculateChange($model)
    {
        $today = $model::whereDate('created_at', today())->count();
        $yesterday = $model::whereDate('created_at', today()->subDay())->count();

        if ($yesterday === 0) {
            return $today > 0 ? 100 : 0;
        }

        return round((($today - $yesterday) / $yesterday) * 100, 2);
    }
    public function getStats()
    {
        return response()->json([
            'totalEvents' => Event::count(),
            'eventChange' => $this->calculateChange(Event::class),
            'totalRentals' => Rental::count(),
            'rentalChange' => $this->calculateChange(Rental::class),
            'totalUsers' => User::count(),
            'userChange' => $this->calculateChange(User::class),
            'totalNews' => Newsletter::count(),
            'newsChange' => $this->calculateChange(Newsletter::class),
        ]);
    }

}
