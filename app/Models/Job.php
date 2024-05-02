<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Wenn Table mehrzahl hat ("JobListings") wird die Einzahl geschrieben.
// Connected mit dem Table "job_listings" in die klasse "Job" == Statt gleicher klassenname
class Job extends Model {
    use HasFactory;

    protected $table = 'job_listings';

    protected $guarded = [];    // Guarded vs fillable [FIELDS] || protected $fillable = ['employer_id', 'title', 'salary'];

    public function employer() {
        return $this->belongsTo(Employer::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, foreignPivotKey: "job_listing_id");
    }
}

