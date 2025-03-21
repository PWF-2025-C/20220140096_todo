class Todo extends Model{
    use HasFactory;
    
    protected $fillable = [
    'title',
    'user_id',
    'is_complete',

    ];

    public function user()
    {return $this->belongsTo(User::class);}
        
    
}