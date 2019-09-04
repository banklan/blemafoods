import Welcome from './components/Welcome';
import FoodStuffs from './components/Foodstuffs';
import FoodStuffShow from './components/FoodStuffShow';
import ProductSearchResult from './components/ProductSearchResult';
import SoupRecipes from './components/Recipes';
import ProductShow from './components/ProductShow';
import Proteins from './components/Proteins';
import FruitsVegs from './components/FruitsVegetables';
import HerbsSpices from './components/HerbsSpices';
import CoffeeTea from './components/CoffeeTea';
import Drinks from './components/Drinks';
import BreakfastCereal from './components/BreakfastCereal';
import EggsDairy from './components/EggsDairy';
import Toiletries from './components/Toiletries';
import Household from './components/Household';
import Groceries from './components/Groceries';
import Kitchen from './components/Kitchen';
import SpecialOrder from './components/SpecialOrder';
import Services from './components/Services';
import test from './components/test';

export default[
    {path: '/', name: 'Welcome', component: Welcome},
    {path: '/raw_foodstuffs', name: 'FoodStuffs', component: FoodStuffs},
    {path: '/raw_foodstuff/:id/:name', name: 'FoodStuffShow', component: FoodStuffShow},
    {path: '/search', name: 'ProductSearchResult', component: ProductSearchResult},
    {path: '/soup-stew-ingredients', name: 'SoupRecipes', component: SoupRecipes},
    {path: '/:cat/:id/:slug', name: 'ProductShow', component: ProductShow},
    {path: '/fish-meat', component:Proteins},
    {path: '/fruits-vegetables', component: FruitsVegs},
    {path: '/herbs-spices', component: HerbsSpices},
    {path: '/coffee-tea', component: CoffeeTea},
    {path: '/beverages-drinks-water', component: Drinks},
    {path: '/breakfast-cereal', component: BreakfastCereal},
    {path: '/eggs-dairy', component: EggsDairy},
    {path: '/toiletries', component: Toiletries},
    {path: '/household', component: Household},
    {path: '/groceries', component: Groceries},
    {path: '/kitchen', component: Kitchen},
    {path: '/special_order', component: SpecialOrder},
    {path: '/special_services/services', component: Services},
    {path: '/test', component: test}
]
