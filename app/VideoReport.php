<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class VideoReport extends Model
{
    use SoftDeletes;
    protected $table = 'video_report';
    
    protected $fillable = [
        'title', 'organization_name', 'organization_url', 'comments', 'video_report','uploaded_by'
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'uploaded_by','id');
    }

    /**
     * Scope a query to only include active Institution Report.
     * Reports not archive and not deleted
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query){
        return $query->where(['archive' => 0, 'deleted_at' => null]);
    }
    
    /**
     * scopeIsLibrary
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeIsLibrary($query){
        return $query->where('send_library', 1);
    }
        
    /**
     * scopeOwn
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeOwn($query){
        $query->where('uploaded_by',  auth()->user()->id);
    }
    /**
     * scopeArchive
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeArchive($query){
        return $query->where(['archive' => 1, 'deleted_at' => null]);
    }
}
