<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\Region;
use App\Models\City;

/**
 * Towns controller provides methods wich u can get acces to all tables data with cities/regions/countries. 
 */
class Towns extends Controller
{
    /**
     * Fetching all countries we have.
     * 
     * @return JSON
     */
    public function fetchCountries()
    {
        $countries = Country::orderBy('title_'.app()->getLocale(), 'asc')->get();
        
        return $countries;
    }

    /**
     * Fetching all regions we have.
     * 
     * @param countryId:int 
     * @return JSON
     */
    public function fetchRegions($countryId)
    {
        $regions = Region::where('country_id',$countryId)
            ->orderBy('title_'.app()->getLocale(), 'asc')
            ->limit(10000)
            ->get();
        return $regions;
    }
    /**
     * Fetching all cities we have.
     * 
     * @param region_id:int 
     * @return JSON
     */
    public function fetchCities($region_id)
    {
        $cities = City::where('region_id',$region_id)
                ->orderBy('title_'.app()->getLocale(), 'asc')
                ->get();
                return $cities;
    }
    /**
     * Fetching all cities we have by paginate methods.
     * 
     * @param region_id:int 
     * @return JSON
     */
    public function paginateCities($region_id)
    {
        $cities = City::where('region_id',$region_id)
                ->orderBy('title_'.app()->getLocale(), 'asc')->paginate(15);
                return $cities;
    }
}
