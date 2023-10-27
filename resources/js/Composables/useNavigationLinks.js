import { isMobile } from 'mobile-device-detect'
import {
  HomeIcon,
  StarIcon,
  Cog6ToothIcon,
  UserIcon,
  PencilIcon,
  CurrencyDollarIcon,
  CalendarIcon,
  ChartBarIcon,
  ChevronRightIcon,
  BoltIcon,
  ClockIcon,
  UsersIcon
} from '@heroicons/vue/24/solid'

export function useNavigationLinks() {
  const navLinks = [
    {
      id: 'nav-home',
      icon: HomeIcon,
      link: 'home',
      label: 'Home'
    },
    {
      id: 'nav-category',
      icon: StarIcon,
      link: 'categories',
      label: 'Categories'
    },
    {
      id: 'nav-calendar',
      icon: CalendarIcon,
      link: 'calendar.index',
      label: 'Calendar',
    },
    {
      id: 'nav-progress',
      icon: ChartBarIcon,
      link: 'chart.index',
      label: 'Progress',
    },
    {
      id: 'nav-settings',
      icon: Cog6ToothIcon,
      link: isMobile ? 'settings' : 'setting.user.index',
      label: 'Settings'
    },

  ]

  const settingNavLinks = [
    {
      icon: UserIcon,
      link: 'setting.user.index',
      label: 'Account Setting',
      description: 'Personal Infomation, Email',
      leftIcon: ChevronRightIcon
    },
    {
      icon: UsersIcon,
      link: 'coming-soon',
      label: 'Accountability Partner',
      description: 'Get additional support from other people',
      leftIcon: ChevronRightIcon
    },
    {
      icon: ClockIcon,
      link: 'setting.reminder.index',
      label: 'Reminder',
      description: 'Schedule your personal reminder',
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
      icon: BoltIcon,
      link: 'setting.history.index',
      label: 'Login History',
      description: 'View your login history',
      leftIcon: ChevronRightIcon
    },
    {
      icon: CurrencyDollarIcon,
      link: 'subscription',
      label: 'Subscription',
      description: 'Manage your subscription'
    }

  ]

  return { navLinks, settingNavLinks }
}
