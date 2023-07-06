import { isMobile } from 'mobile-device-detect'
import {
  HomeIcon,
  StarIcon,
  Cog6ToothIcon,
  UserIcon,
  LockClosedIcon,
  BugAntIcon,
  PencilIcon,
  CurrencyDollarIcon,
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
      icon: CalendarIcon,
      link: 'calendar.index',
      label: 'Calendar',
    },
    {
      icon: ChartBarIcon,
      link: 'chart.index',
      label: 'My Progress',
    },
    {
      icon: Cog6ToothIcon,
      link: isMobile ? 'settings' : 'setting.user.index',
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
      description: 'Manage your subscription'
    }

  ]

  return { navLinks,settingNavLinks }
}
