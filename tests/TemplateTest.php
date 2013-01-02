<?php
/**
 * Write a "template engine" meaning a way to transform template strings, "Hello 
 * {$name}" into "instanced" strings. To do that a variable->value mapping must 
 * be provided. For example, if name="Cenk" and the template string is "Hello 
 * {$name}" the result would be "Hello Cenk".
 * **Should evaluate template single variable expression**:
 * - mapOfVariables.put("name","Cenk");
 * - templateEngine.evaluate("Hello {$name}", mapOfVariables)
 * - should evaluate to "Hello Cenk"
 * 
 * **Should evaluate template with multiple expressions**:
 * - mapOfVariables.put("firstName","Cenk");
 * - mapOfVariables.put("lastName","Civici");
 * - templateEngine.evaluate("Hello {$firstName} ${lastName}", mapOfVariables);
 * - should evaluate to "Hello Cenk Civici"
 * 
 * **Should give error if template variable does not exist in the map**:
 * - map empty
 * - templateEngine.evaluate("Hello {$firstName} ", mapOfVariables);
 * - should throw missingvalueexception
 * 
 * **Should evaluate complex cases**:
 * - mapOfVariables.put("name","Cenk");
 * - templateEngine.evaluate("Hello ${$name}}", mapOfVariables);
 * - should evaluate to "Hello ${Cenk}"
 */
class TemplateTest extends PHPUnit_Framework_TestCase 
{
    public function testSingleVariable()
    {
        $template = new Template();
        $template['name'] = "Cenk";
        $output = $template->renderString('Hello {$name}');
        
        $this->assertEquals("Hello Cenk", $output);
    }
    
    public function testMultipleVariable()
    {
        $template = new Template();
        $template['firstName'] = "Cenk";
        $template['lastName'] = "Civici";
        $output = $template->renderString('Hello {$firstName} {$lastName}');
        
        $this->assertEquals("Hello Cenk Civici", $output);
    }
    
    public function testMissingVariable()
    {
        $this->setExpectedException('MissingValueException');
        $template = new Template();
        $output = $template->renderString('Hello {$firstName} ');
    }
    
    public function testComplexCases()
    {
        $template = new Template();
        $template['name'] = "Cenk";
        $output = $template->renderString('Hello ${{$name}}');
        
        $this->assertEquals('Hello ${Cenk}', $output);
    }
}