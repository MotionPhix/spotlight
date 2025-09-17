<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Communication extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\CommunicationFactory> */
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'sent_by',
        'type',
        'recipient_type',
        'recipients',
        'subject',
        'message',
        'metadata',
        'sent_count',
        'failed_count',
        'status',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'recipients' => 'array',
            'metadata' => 'array',
            'sent_at' => 'datetime',
        ];
    }

    public function sentBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function getRecipientsCount(): int
    {
        return match ($this->recipient_type) {
            'all' => User::where('is_admin', false)->count(),
            'status' => User::where('is_admin', false)->whereIn('registration_status', $this->recipients ?? [])->count(),
            'individual' => count($this->recipients ?? []),
            default => 0,
        };
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments')
            ->acceptsMimeTypes([
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'image/jpeg',
                'image/png',
                'image/gif',
                'text/plain',
                'application/zip',
            ]);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->performOnCollections('attachments')
            ->nonQueued();
    }
}
