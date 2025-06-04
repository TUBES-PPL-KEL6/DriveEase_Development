<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Review;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminReviewManagementTest extends DuskTestCase
{
    /**
     * Test that admin can view all reviews
     * TC.AdminDelRev.001
     */
    public function test_admin_can_view_all_reviews()
    {
        $this->browse(function (Browser $browser) {
            // Create test data
            $admin = User::factory()->create(['role' => 'admin']);
            $reviews = Review::factory()->count(3)->create();

            // Login as admin and check review list
            $browser->loginAs($admin)
                   ->visit('/admin/reviews')
                   ->assertSee('Manajemen Ulasan')
                   ->assertPresent('table')
                   ->assertSee($reviews[0]->comment)
                   ->assertSee($reviews[1]->comment)
                   ->assertSee($reviews[2]->comment);
        });
    }

    /**
     * Test admin review deletion confirmation
     * TC.AdminDelRev.002
     */
    public function test_admin_review_deletion_confirmation()
    {
        $this->browse(function (Browser $browser) {
            // Create test data
            $admin = User::factory()->create(['role' => 'admin']);
            $review = Review::factory()->create();

            // Login as admin and attempt to delete review
            $browser->loginAs($admin)
                   ->visit('/admin/reviews')
                   ->click('@delete-review-' . $review->id)
                   ->assertDialogOpened('Apakah Anda yakin ingin menghapus ulasan ini?')
                   ->acceptDialog()
                   ->assertDontSee($review->comment);
        });
    }
} 