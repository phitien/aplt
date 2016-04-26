// Extend Validation with custom rules 
Validation.extendErrors({
    isNotValidUser: {
        className: 'ui-input_state_invalid-user',
        message: 'not equal to "Alex"',
        rule: function(value) {
            // Validation provides ref to 'Validator' module, so you don't need to install it separately 
            return Validator.trim(value) === 'Alex';
        }
    },
    isRequired: {
        className: 'ui-input_state_empty',
        message: 'required',
        rule: function(value) {
            return Boolean(Validator.trim(value));
        }
    },
    isEmail: {
        className: 'ui-input_state_email-pattern-failed',
        // Validator already has strong email-pattern, so we don't have to extend it by custom 
        message: 'should be email'
    }
});
 
var Form = React.createClass({
    onSubmit: function(event) {
        event.preventDefault();
        console.log(event);
    },
 
    render: function() {
        return (
            <Validation.Form onSubmit={this.onSubmit}>
                <label>
                    Just a label for username
                    <Validation.Input
                        blocking='input'
                        className='ui-input'
                        validations={[
                          {
                              rule: 'isRequired'
                          },
                          {
                              rule: 'isNotValidUser'
                          }
                        ]}
                        invalidClassName='ui-input_state_custom-error-classname'
                        name='username'
                        type='text'/>
                </label>
                // Passing wrapper prop will extra wrap the input with passed Component and it's props 
                <Validation.Input wrapper={{component: MaskedInput, props: {mask: '11/11/1111'}}} name='birthday' onChange={function(event) {console.log(event.target.value)}} validations={[
                    {
                        rule: 'isRequired'
                    }
                ]} />
                <Validation.Input
                    blocking='input'
                    className='ui-input'
                    validations={[
                        {
                            rule: 'isEmail'
                        }
                    ]}
                    name='email'
                    type='text'/>
                <Validation.Input
                    blocking='input'
                    className='ui-input'
                    validations={[
                        {
                            rule: 'isRequired',
                            errorMessage: 'required'
                        }
                    ]}
                    name='password'
                    type='password'/>
                <Validation.Button blocking='button' value='submit'/>
            </Validation.Form>
        );
    }
});