<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoiController extends Controller
{
    public function prepRoiBillBoard(Request $request) {
        $compeProductCost = base64_decode($request->input('compeProductCost'));
        $competitorTotalStaffsPerDay = base64_decode($request->input('competitorTotalStaffsPerDay'));
        $competitorLabourCost = base64_decode($request->input('competitorLabourCost'));
        $competitorWorkingHoursPerDay = base64_decode($request->input('competitorWorkingHoursPerDay'));
        $competitorWorkingDaysPerMonth = base64_decode($request->input('competitorWorkingDaysPerMonth'));
        $competitorProdPetrolCostHourly = base64_decode($request->input('competitorProdPetrolCostHourly'));
        $competitorProdMaintenanceCost =  base64_decode($request->input('competitorProdMaintenanceCost'));
        $competitorProdInitalNRuningTotalCostAyear = $request->input('competitorProdInitalNRuningTotalCostAyear');
        $makitaProdCost = base64_decode($request->input('makitaProdCost'));
        $makitaProdElectricityPerCharge =  base64_decode($request->input('makitaProdElectricityPerCharge'));
        $makitaProdBatteryCost =  base64_decode($request->input('makitaProdBatteryCost'));
        $makitaProdBatteryQty =  base64_decode($request->input('makitaProdBatteryQty'));
        $makitaProdChargerCost =  base64_decode($request->input('makitaProdChargerCost'));
        $makitaProdChargerQuantity =  base64_decode($request->input('makitaProdChargerQuantity'));
        $makitaProdTotalStaffsPerDay = base64_decode($request->input('makitaProdTotalStaffsPerDay'));
        $makitaProductLabourCost = base64_decode($request->input('makitaProductLabourCost'));
        $makitaProdNoOfChargeNeededADay = base64_decode($request->input('makitaProdNoOfChargeNeededADay'));
        $makitaProductMaintenanceCost = base64_decode($request->input('makitaProductMaintenanceCost'));
        $makitaProdInitalNRuningTotalCostAyear = $request->input('makitaProdInitalNRuningTotalCostAyear');

        $totalMakitaBatteryCost = (!empty($makitaProdBatteryCost) ? $makitaProdBatteryCost : 0) * (!empty($makitaProdBatteryQty) ? $makitaProdBatteryQty : 0);
        $totalMakitaProdChargerCost = (!empty($makitaProdChargerCost) ? $makitaProdChargerCost : 0) * (!empty($makitaProdChargerQuantity) ? $makitaProdChargerQuantity : 0);


        $makitaProdCostIncludeBatteryCharger= $makitaProdCost + $totalMakitaBatteryCost + $totalMakitaProdChargerCost;

        if($competitorTotalStaffsPerDay !=null && $competitorLabourCost !=null){
            $result['compeTotalLabourCostInAYear'] = (($competitorTotalStaffsPerDay*$competitorLabourCost)*$competitorWorkingDaysPerMonth)*12;
        }else{
            $result['compeTotalLabourCostInAYear'] = 0;

        }

        if($makitaProdTotalStaffsPerDay !=null && $makitaProductLabourCost !=null){
            $result['makitaTotalLabourCostInAYear'] = (($makitaProdTotalStaffsPerDay*$makitaProductLabourCost)*$competitorWorkingDaysPerMonth)*12;
        }else{
            $result['makitaTotalLabourCostInAYear'] = 0;

        }

        $result['compeProductCost'] = $compeProductCost;
        $result['competitorProdMaintenanceCost'] = $competitorProdMaintenanceCost;

        $result['makitaProdCost'] = $makitaProdCostIncludeBatteryCharger;
        $result['makitaProductMaintenanceCost'] = $makitaProductMaintenanceCost;


        $result['mPOneYearBattaryConsumCost'] = ($makitaProdElectricityPerCharge * $makitaProdNoOfChargeNeededADay) * ($competitorWorkingDaysPerMonth * 12);
        $result['competitorProdYearFuelConsumption'] = ($competitorWorkingHoursPerDay * $competitorWorkingDaysPerMonth)*($competitorProdPetrolCostHourly * 12);

        $result['competitorProdGenaralExpensesInAYear'] = $competitorProdMaintenanceCost+$result['compeTotalLabourCostInAYear'] ;

        //Money Back Calculation
        $competitorOneYearCostWithoutProduct = $result['competitorProdYearFuelConsumption'] + $competitorProdMaintenanceCost + $result['compeTotalLabourCostInAYear'] ;
        $result['competitorProdGenaralExpensesInAMonth'] = $competitorOneYearCostWithoutProduct/12;


        $makitaProdOneYearElcetrcityConsumptionCharges = (($competitorWorkingDaysPerMonth * 12)*$makitaProdNoOfChargeNeededADay)*$makitaProdElectricityPerCharge;
        $makitaProductOneYearRuningCost=$makitaProdOneYearElcetrcityConsumptionCharges + $result['makitaTotalLabourCostInAYear'] + $makitaProductMaintenanceCost;

        $makitaProdMonthlyRuningCost= $makitaProductOneYearRuningCost/12;
        $monthlyRuningCostDiffrenceBothProduct= ($result['competitorProdGenaralExpensesInAMonth'] - $makitaProdMonthlyRuningCost);

        $makitaNCompetitorProductCostDiffrent=abs($makitaProdCostIncludeBatteryCharger-$compeProductCost);
        if ($monthlyRuningCostDiffrenceBothProduct != 0) {
            $result['achiveIn'] = round($makitaNCompetitorProductCostDiffrent / $monthlyRuningCostDiffrenceBothProduct);
        } else {
            $result['achiveIn'] = 0; // or any default value you'd like to set when division can't be performed
        }
        $result['compeProdOneYearTotalCost'] = $competitorOneYearCostWithoutProduct + $compeProductCost;
        $result['makitaprodyeartotalcost'] = $makitaProdCostIncludeBatteryCharger+$result['mPOneYearBattaryConsumCost']+$makitaProductMaintenanceCost+$result['makitaTotalLabourCostInAYear'];

        $result['makitaProdRunningExpensesInAYear'] = $makitaProductMaintenanceCost+$result['makitaTotalLabourCostInAYear']+$result['mPOneYearBattaryConsumCost'];

        $result['makitaProdGenaralExpensesInAYear'] = $makitaProductMaintenanceCost+$result['makitaTotalLabourCostInAYear'];
        $result['makitaProdGenaralExpensesInAMonth'] = $result['makitaProdRunningExpensesInAYear']/12;

        return view('Admin.roi', $result);

    }
}
