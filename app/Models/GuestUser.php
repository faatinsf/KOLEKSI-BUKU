<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model
{
    protected $fillable = ['nama_guest'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Auto-generate nama_guest format Guest_0000001
     */
    public static function buatGuest(): self
    {
        $last = self::latest('id')->first();
        $nextId = $last ? $last->id + 1 : 1;
        $namaGuest = 'Guest_' . str_pad($nextId, 7, '0', STR_PAD_LEFT);

        return self::create(['nama_guest' => $namaGuest]);
    }
}
