export function useAppIntro() {
  const homeSteps = [
    { 
      attachTo: { element: '#affirmation' }, 
      content: { 
        title: 'Daily Affirmation', 
        description: 'You will be given a random affirmation each day based on your active category.' 
      },
    },
    {
      attachTo: { element: '#affirmation-button' }, 
      content: { 
        title: 'Starting Your Exercise', 
        description: 'Then you can start your exercise once each day by clicking this button.' 
      },
      options: {
        popper: {
          placement: 'top'
        }
      } 
    },
    {
      attachTo: { element: '#nav-category' }, 
      content: { 
        title: 'Switching Categories', 
        description: 'Now if you want to change or to look for a different category, then you can go to the categories. Each category contains a unique affirmation that will be displayed randomly each day' 
      },
      options: {
        popper: {
          placement: 'top'
        }
      } 
    },
    {
      attachTo: { element: '#nav-calendar' }, 
      content: { 
        title: 'Affirmation Record', 
        description: 'If you want to see the records of each affirmation you\'ve taken, you can simply go to this page' 
      },
      options: {
        popper: {
          placement: 'top'
        }
      } 
    },
    {
      attachTo: { element: '#nav-progress' }, 
      content: { 
        title: 'Affirmation Progress', 
        description: 'Now if you want to see your progress in your affirmation exercise you can go here.' 
      },
      options: {
        popper: {
          placement: 'top'
        }
      } 
    },
    {
      attachTo: { element: '#nav-settings' }, 
      content: { 
        title: 'Application Settings', 
        description: 'For account and app configuration including dark mode, feedback and bug reporting, you can go here' 
      } ,
      options: {
        popper: {
          placement: 'top'
        }
      }
    },
  ]

  return { homeSteps }
}