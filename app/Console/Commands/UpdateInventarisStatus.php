<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventaris;

class UpdateInventarisStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventaris:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status inventaris berdasarkan stok saat ini';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating inventaris status...');

        $inventaris = Inventaris::all();
        $updated = 0;

        foreach ($inventaris as $item) {
            $oldStatus = $item->status;

            // Determine new status based on stock
            if ($item->stok_saat_ini <= 0) {
                $item->status = 'habis';
            } elseif ($item->stok_saat_ini <= $item->stok_minimal) {
                $item->status = 'hampir_habis';
            } else {
                $item->status = 'tersedia';
            }

            // Only save if status changed
            if ($oldStatus !== $item->status) {
                $item->save();
                $updated++;
                $this->line("✓ {$item->nama_barang}: {$oldStatus} → {$item->status} (stok: {$item->stok_saat_ini})");
            }
        }

        $this->info("\n✅ Updated {$updated} items successfully!");
        $this->info("📊 Total items: {$inventaris->count()}");

        return 0;
    }
}
