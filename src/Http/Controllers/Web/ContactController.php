<?php

declare(strict_types=1);

namespace Tipoff\Forms\Http\Controllers\Web;

use App\Models\Location;
use App\Models\Market;
use DrewRoberts\Media\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ContactController extends Controller
{
    public function __invoke(Request $request, Market $market = null, Location $location = null)
    {
        $current = getCurrentMarket($request);

        // Redirect to the user's current market if they have one set and end up on page in company section
        if ($current && $request->segment(1) === 'company') {
            return redirect()->to($current->slug);
        }

        $image = Image::find(40)->url;

        // Show the page in the company section of the site
        if ($request->segment(1) === 'company') {
            return view('website.pages.company.choose', [
                'market' => $current,
                'html' => null, // set to true if need to use html page instead of AMP
                'title' => 'Contact Us',
                'subtitle' => 'Please select your location from the dropdown below:',
                'cta' => null,
                'link' => 'contact',
                'seotitle' => 'Contact Us at The Great Escape Room',
                'seodescription' => 'Contact Us at The Great Escape Room, a leader in the escape room industry with 12 locations. Visit our website to learn more.',
                'ogtitle' => 'Contact Us at The Great Escape Room',
                'ogdescription' => 'Contact Us at The Great Escape Room, a leader in the escape room industry with 12 locations. Visit our website to learn more.',
                'canonical' => route('contact'),
                'image' => $image,
                'ogimage' => $image === null ? url('img/ogimage.jpg') : $image,
            ]);
        }

        // Send to correct market if somehow they get to a URL with a different market than where the location belongs
        if ($location && $market->id !== $location->market_id) {
            return redirect()->to($location->slug);
        }

        // If there is only one location in the market, remove the trailing location name in the route/URL
        if ($market->locations_count === 1 && $location) {
            return redirect()->to($market->slug);
        }

        setCurrentMarket($request, $market);

        // In a multi-location market, ask the user to choose a location
        if ($market->locations_count !== 1 && ! $location) {
            return view('website.markets.select', [
                'market' => $market,
                'html' => null, // set to true if need to use html page instead of AMP
                'title' => 'Contact Us',
                'subtitle' => 'Please select your location from the dropdown below:',
                'cta' => null,
                'link' => 'contact',
                'seotitle' => 'Contact Us at The Great Escape Room',
                'seodescription' => 'Contact Us at The Great Escape Room, a leader in the escape room industry with 12 locations. Visit our website to learn more.',
                'ogtitle' => 'Contact Us at The Great Escape Room',
                'ogdescription' => 'Contact Us at The Great Escape Room, a leader in the escape room industry with 12 locations. Visit our website to learn more.',
                'canonical' => 'https://thegreatescaperoom.com'.$market->slug,
                'image' => $image,
                'ogimage' => $image === null ? url('img/ogimage.jpg') : $image,
            ]);
        }

        // If end up here, then display the bookings page
        if (! $location) {
            $location = $market->locations->first();
        }

        return view('website.pages.contact', [
            'market' => $market,
            'location' => $location,
            'html' => null,
            'title' => 'Contact Us at '.$market->title,
            'subtitle' => 'Please fill in your info below and we\'ll be in touch',
            'cta' => null,
            'seotitle' => 'Contact Us at '.$market->title,
            'seodescription' => $market->title.' has '.$market->rooms->count().' different escape rooms and offers private escape games for groups & parties. Contact us today for more information!',
            'ogtitle' => 'Contact Us at '.$market->title,
            'ogdescription' => $market->title.' has '.$market->rooms->count().' different escape rooms and offers private escape games for groups & parties. Contact us today for more information!',
            'canonical' => 'https://thegreatescaperoom.com'.$location->slug,
            'image' => $image,
            'ogimage' => $image === null ? url('img/ogimage.jpg') : $image,
        ]);
    }

    public function confirmation(Request $request, Market $market, Location $location = null)
    {
        $image = Image::find(40)->url;
        $location = $location ? $location : $market->locations()->first();

        return view('website.pages.confirmation.contact', [
            'market' => $market,
            'location' => $location,
            'noindex' => true, // Prevent Google and other search engines from indexing this page.
            'title' => 'Thank you for contacting us',
            'subtitle' => 'We will be in touch soon!',
            'cta' => null,
            'canonical' => 'https://thegreatescaperoom.com'.$location->slug,
            'image' => $image,
            'ogimage' => $image === null ? url('img/ogimage.jpg') : $image,
        ]);
    }
}
