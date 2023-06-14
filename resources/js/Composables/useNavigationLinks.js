import { 
  HomeIcon, 
  StarIcon, 
  SparklesIcon, 
  Cog6ToothIcon 
} from '@heroicons/vue/24/solid'

export function useNavigationLinks() {
  const navLinks = [
    {
      icon: HomeIcon,
      link: 'home',
      label: 'Home'
    },
    {
      icon: StarIcon,
      link: 'categories',
      label: 'Categories'
    },
    {
      icon: SparklesIcon,
      link: 'home',
      label: 'Premium'
    },    
    {
      icon: Cog6ToothIcon,
      link: 'settings',
      label: 'Settings'
    },    
  ]

  return { navLinks }
}