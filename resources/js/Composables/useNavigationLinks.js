import { 
  HomeIcon, 
  StarIcon, 
  SparklesIcon, 
  Cog6ToothIcon,
  PaintBrushIcon,
  UserIcon,
  LockClosedIcon,
  BugAntIcon,
  PencilIcon,
  CurrencyDollarIcon,
  ListBulletIcon,
  CalendarIcon,
  ChartBarIcon,
  ChevronRightIcon
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
      icon: PaintBrushIcon,
      link: 'themes',
      label: 'Themes'
    },
    {
      icon: SparklesIcon,
      link: 'premium',
      label: 'Premium'
    },    
    {
      icon: Cog6ToothIcon,
      link: 'setting.user.index',
      label: 'Settings'
    },    
  ]

  const settingNavLinks = [
    {
      icon: UserIcon,
      link: 'setting.user.index',
      label: 'Account Settings',
      description: 'Personal Infomation, Email',
      leftIcon: ChevronRightIcon
    },
    {
      icon: LockClosedIcon,
      link: 'setting.security.index',
      label: 'Security',
      description: 'Change Password',
      leftIcon: ChevronRightIcon
    },
    {
      icon: BugAntIcon,
      link: 'setting.reportbug.index',
      label: 'Report Bug',
      description: 'Write a report to help',
      leftIcon: ChevronRightIcon
    },
    {
      icon: PencilIcon,
      link: 'setting.feedback.index',
      label: 'Feedback',
      description: 'Write feedback to help',
      leftIcon: ChevronRightIcon
    },
    {
      icon: CurrencyDollarIcon,
      link: 'subscription',
      label: 'Subscription',
      description: ''
    },
    {
      icon: ListBulletIcon,
      link: 'setting.useraffirmation.index',
      label: 'Add Own',
      description: '',
      leftIcon: ChevronRightIcon
    },
    {
      icon: CalendarIcon,
      link: 'setting.calendar.index',
      label: 'Calendar',
      description: '',
      leftIcon: ChevronRightIcon
    },
    {
      icon: ChartBarIcon,
      link: 'setting.chart.index',
      label: 'Chart',
      description: '',
      leftIcon: ChevronRightIcon
    },
  ]

  return { navLinks,settingNavLinks }
}